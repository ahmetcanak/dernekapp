import 'dart:io';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bin/atom.dart' as atom;
import 'package:dernek_app/bloc/device/index.dart';

class DeviceBloc extends Bloc<DeviceEvent, Map<String, dynamic>> {
  @override
  Map<String, dynamic> get initialState => {
        'storage': null,
        'deviceId': null,
        'app': {},
        'firebaseMessaging': FirebaseMessaging(),
        'firebaseToken': '',
      };

  DeviceBloc() {
    firebaseCloudMessagingListener();
  }

  firebaseCloudMessagingListener() {
    if (Platform.isIOS) iOSPermission();
    state['firebaseMessaging'].subscribeToTopic('all');
    state['firebaseMessaging'].getToken().then((token) {
      state['firebaseToken'] = token;
      print('firebase token: $token');
    });

    state['firebaseMessaging'].configure(
      onMessage: (Map<String, dynamic> message) async {
        print('firebase on message $message');
      },
      onResume: (Map<String, dynamic> message) async {
        print('firebase on resume $message');
      },
      onLaunch: (Map<String, dynamic> message) async {
        print('firebase on launch $message');
      },
    );
  }

  iOSPermission() {
    state['firebaseMessaging'].requestNotificationPermissions(
      IosNotificationSettings(sound: true, badge: true, alert: true),
    );
    state['firebaseMessaging']
        .onIosSettingsRegistered
        .listen((IosNotificationSettings settings) {
      print("firebase settings registered IOS: $settings");
    });
  }

  @override
  Stream<Map<String, dynamic>> mapEventToState(DeviceEvent event) async* {
    if (event is SetStorage) {
      yield atom.setState(state: state, newState: {
        'storage': event.storage,
      });
    }
  }
}
