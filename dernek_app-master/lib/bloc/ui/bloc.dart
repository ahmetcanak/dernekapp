import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/ui/index.dart';
import 'package:dernek_app/bin/atom.dart' as atom;
import 'package:dernek_app/bin/theme.dart' as theme;

class UIBloc extends Bloc<UIEvent, Map<String, dynamic>> {
  @override
  Map<String, dynamic> get initialState => {
        'scaffoldKey': null,
        'navigatorKey': GlobalKey<NavigatorState>(),
      };

  @override
  Stream<Map<String, dynamic>> mapEventToState(UIEvent event) async* {
    if (event is SetScaffoldKey) {
      yield atom
          .setState(state: state, newState: {'scaffoldKey': event.scaffoldKey});
    } else if (event is AddSnackBar) {
      // Snackbar oluştur
      Map<String, dynamic> snackBarTheme = theme.defaultTheme['snackBar'];
      final snackBar = SnackBar(
        duration: event.duration,
        content: Text(
          event.message,
          style: TextStyle(
            color: snackBarTheme[event.type + 'Color'],
          ),
        ),
        backgroundColor: snackBarTheme[event.type + 'BackgroundColor'],
      );
      state['scaffoldKey'].currentState.showSnackBar(snackBar);
    } else if (event is NavigateTo) {
      // Route'a yönlendir
      print("route: " +
          event.route.toString() +
          ', arguments: ' +
          event.arguments.toString());
      state['navigatorKey'].currentState.pushNamed(
            event.route,
            arguments: event.arguments,
          );
    } else if (event is NavigateUntilTo) {
      // Arkada bir şey bırakmadan yönlendir
      print("until route: " +
          event.route.toString() +
          ', arguments: ' +
          event.arguments.toString());
      state['navigatorKey'].currentState.pushNamedAndRemoveUntil(
            event.route,
            ModalRoute.withName('/'),
            // arguments: event.arguments,
          );
    } else if (event is NavigatePop) {
      state['navigatorKey'].currentState.pop();
    }
  }
}
