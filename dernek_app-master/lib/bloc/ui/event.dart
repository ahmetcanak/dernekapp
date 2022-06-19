import 'package:flutter/material.dart';

abstract class UIEvent {}

class AddSnackBar extends UIEvent {
  final String message;
  final String type;
  final Duration duration;
  AddSnackBar({
    this.message,
    this.duration: const Duration(seconds: 1),
    this.type: 'default',
  });
}

class SetScaffoldKey extends UIEvent {
  final GlobalKey<ScaffoldState> scaffoldKey;
  SetScaffoldKey({this.scaffoldKey});
}

class NavigateTo extends UIEvent {
  final String route;
  final dynamic arguments;
  NavigateTo({this.route, this.arguments});
}

class NavigateUntilTo extends UIEvent {
  final String route;
  final dynamic arguments;
  NavigateUntilTo({this.route, this.arguments});
}

class NavigatePop extends UIEvent {
  NavigatePop();
}
