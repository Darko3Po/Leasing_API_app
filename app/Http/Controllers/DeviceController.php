<?php

namespace App\Http\Controllers;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DeviceController extends Controller
{
      public function register(Request $request)
    {
        $deviceId = $request->input('deviceId');
        $activationCode = $request->input('activationCode');

        // Check if the device exists
        $device = Device::where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        if ($device->device_type === 'leasing') {
            return response()->json(['error' => 'Device is already registered'], 400);
        }

        // Registration logic
        if ($activationCode) {
            // Check if the activation code is valid
            // Implement your logic to validate the code
            if (!$this->isValidActivationCode($activationCode)) {
                return response()->json(['error' => 'Invalid activation code'], 400);
            }
            // Associate activation code with the device
            $device->activation_code = $activationCode;
        }

        // Generate a unique device API key
        $device->device_api_key = Str::random(32);

        // Set the device type to 'leasing'
        $device->device_type = 'leasing';

        $device->save();

        return response()->json([
            'deviceId' => $device->device_id,
            'deviceAPIKey' => $device->device_api_key,
            'deviceType' => $device->device_type,
            'timestamp' => now(),
        ], 201);
    }

    public function info($id)
    {
        $device = Device::where('device_id', $id)->first();
        //if device not found
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $responseData = [
            'deviceId' => $device->device_id,
            'deviceType' => $device->device_type,
            'timestamp' => now(),
        ];
        // if the device type is leasing
        if ($device->device_type === 'leasing') {
            $responseData['deviceOwner'] = 'WebOrigo Magyarország Zrt.';
            $responseData['deviceOwnerDetails'] = [
                'billing_name' => 'WebOrigo Magyarország Zrt.',
                'address_country' => '348',
                'address_zip' => '1027',
                'address_city' => 'Budapest',
                'address_street' => 'Bem József utca 9. fszt.',
                'vat_number' => '28767116-2-41',
            ];
            $responseData['dateofRegistration'] = '2021-11-04';
            $responseData['leasingPeriodsComputed'] = [
                'leasingConstructionId' => 51342268,
                'leasingConstructionMaximumTraining' => 1000,
                'leasingConstructionMaximumDate' => '2021-06-01',
                'leasingActualPeriodStartDate' => '2021-12-01',
                'leasingNextCheck' => '2021-12-01 17:30:00',
            ];
            $responseData['leasingPeriods'] = [
                [
                    'leasingConstructionId' => 51342268,
                    'leasingConstructionMaximumTraining' => 1000,
                    'leasingConstructionMaximumDate' => '2021-06-01',
                ],
                [
                    'leasingConstructionId' => 42115269,
                    'leasingConstructionMaximumTraining' => null,
                    'leasingConstructionMaximumDate' => '2021-10-01',
                ],
                [
                    'leasingConstructionId' => 28524612,
                    'leasingConstructionMaximumTraining' => 50,
                    'leasingConstructionMaximumDate' => null,
                ],
            ];
        }

        return response()->json($responseData, 200);
    }

    public function update(Request $request, $id)
    {
        // Find the device by its ID
        $device = Device::where('device_id', $id)->first();

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        // Check if the device is a 'leasing' type
        if ($device->device_type !== 'leasing') {
            return response()->json(['error' => 'Device is not a leasing device'], 400);
        }

        // Extract the leasing data from the request
        $leasingData = $request->only(['trainingPeriod', 'maxTraining', 'nextCheck']);

        // Update the leasing data
        $device->leasing_data = json_encode($leasingData);

        // Save the changes
        $device->save();

        return response()->json(['message' => 'Leasing data updated successfully'], 200);
    }

    private function isValidActivationCode($activationCode)
    {
        // Implement your validation logic for activation codes here
        return true; // For this example, assume all activation codes are valid
    }

}
