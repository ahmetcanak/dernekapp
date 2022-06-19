import 'package:dernek_app/screen/auth_screen.dart';
import 'package:dernek_app/screen/home_screen/news/detail.dart';
import 'package:dernek_app/screen/register_screen.dart';
import 'package:flutter/material.dart';
import 'package:dernek_app/screen/landing_screen.dart';
import 'package:dernek_app/screen/home_screen/index.dart';
import 'package:dernek_app/screen/login_screen.dart';

class RouterGenerator {
  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case authScreenRoute:
        return MaterialPageRoute(builder: (_) => AuthScreen());
      case landingScreenRoute:
        return MaterialPageRoute(builder: (_) => LandingScreen());
      case homeScreenRoute:
        return MaterialPageRoute(builder: (_) => HomeScreen());
      case loginScreenRoute:
        return MaterialPageRoute(builder: (_) => LoginScreen());
      case registerScreenRoute:
        return MaterialPageRoute(builder: (_) => RegisterScreen());
      case newDetailScreen:
        return MaterialPageRoute(
            builder: (_) => NewDetailScreen(arguments: settings.arguments));
      default:
        return MaterialPageRoute(
          builder: (_) => Scaffold(
            appBar: AppBar(),
            body: Center(
              child: Text('Ters giden birşeyler oldu'),
            ),
          ),
        );
    }
  }
}

const String authScreenRoute = '/';
const String landingScreenRoute = '/landing';
const String homeScreenRoute = '/home';
const String loginScreenRoute = '/login';
const String registerScreenRoute = '/register';
const String newDetailScreen = '/newDetail';
