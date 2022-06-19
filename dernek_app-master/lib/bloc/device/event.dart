import 'package:shared_preferences/shared_preferences.dart';

abstract class DeviceEvent {}

class SetStorage extends DeviceEvent {
  final SharedPreferences storage;
  SetStorage(this.storage);
}

class SetDeviceId extends DeviceEvent {
  final String deviceId;
  SetDeviceId(this.deviceId);
}

class SetApp extends DeviceEvent {
  final Map app;
  SetApp(this.app);
}
