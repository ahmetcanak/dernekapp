import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:dernek_app/router.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/bin/config.dart' as config;
import 'package:dernek_app/bin/theme.dart' as theme;

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SystemChrome.setEnabledSystemUIOverlays([]);
  await SystemChrome.setPreferredOrientations([DeviceOrientation.portraitUp]);
  runApp(App());
}

class App extends StatelessWidget {
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider<Bloc.UserBloc>(
          create: (context) => Bloc.UserBloc(),
        ),
        BlocProvider<Bloc.UIBloc>(
          create: (context) => Bloc.UIBloc(),
        ),
        BlocProvider<Bloc.DeviceBloc>(
          create: (context) => Bloc.DeviceBloc(),
        ),
      ],
      child: BlocBuilder<Bloc.UIBloc, Map>(
        builder: (context, ui) {
          return MaterialApp(
            title: config.appName,
            onGenerateRoute: RouterGenerator.generateRoute,
            debugShowCheckedModeBanner: false,
            // Bu kısım başlangıç sayfası. Uygıulamanın açılması halinde silinmesi gerekir
            // home: RegisterScreen(),
            navigatorKey: ui['navigatorKey'],
            theme: ThemeData(
              fontFamily: 'Poppins',
              primaryColor: theme.color,
              primarySwatch: Colors.grey,
              accentColor: theme.color,
              bottomAppBarColor: theme.color,
              cursorColor: Colors.red,
              canvasColor: theme.backgroundColor,
              textTheme: TextTheme(/*
                display2: TextStyle(
                  fontFamily: 'OpenSans',
                  fontSize: 45.0,
                  color: Colors.orange,
                ),
                button: TextStyle(
                  fontFamily: 'OpenSans',
                ),
                subhead: TextStyle(fontFamily: 'NotoSans'),
                body1: TextStyle(fontFamily: 'NotoSans'),
              */),
            ),
          );
        },
      ),
    );
  }
}
