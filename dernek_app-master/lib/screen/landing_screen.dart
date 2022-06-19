import 'package:flutter/material.dart';
import 'package:dernek_app/component/delayed_animation.dart';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/ui/index.dart' as Bloc;

class LandingScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _LandingScreenState();
}

class _LandingScreenState extends State with SingleTickerProviderStateMixin {
  final int delayedAmount = 500;
  double _scale;
  AnimationController _controller;

  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  Bloc.UIBloc _uiBloc;

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // Animasyon
    _controller = AnimationController(
      vsync: this,
      duration: Duration(milliseconds: 200),
      lowerBound: 0.0,
      upperBound: 0.1,
    )..addListener(() {
        setState(() {});
      });
  }

  @override
  Widget build(BuildContext context) {
    final color = Colors.white;
    _scale = 1 - _controller.value;
    return Scaffold(
      key: _scaffoldKey,
      backgroundColor: theme.color,
      body: SafeArea(
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              DelayedAnimation(
                child: Text(
                  "Hoş Geldiniz",
                  style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 35.0,
                      color: color),
                ),
                delay: delayedAmount + 1000,
              ),
              // DelayedAnimation(
              //   child: Text(
              //     ":)",
              //     style: TextStyle(
              //         fontWeight: FontWeight.bold,
              //         fontSize: 35.0,
              //         color: color),
              //   ),
              //   delay: delayedAmount + 2000,
              // ),
              SizedBox(
                height: 30.0,
              ),
              DelayedAnimation(
                child: Text(
                  config.appName,
                  style: TextStyle(fontSize: 20.0, color: color),
                ),
                delay: delayedAmount + 3000,
              ),
              DelayedAnimation(
                child: Text(
                  config.appSlug,
                  style: TextStyle(fontSize: 20.0, color: color),
                ),
                delay: delayedAmount + 3000,
              ),
              SizedBox(
                height: 100.0,
              ),
              DelayedAnimation(
                child: GestureDetector(
                  onTapDown: _onTapDown,
                  onTapUp: _onTapUp,
                  child: Transform.scale(
                    scale: _scale,
                    child: _animatedButtonUI,
                  ),
                ),
                delay: delayedAmount + 4000,
              ),
              SizedBox(
                height: 50.0,
              ),
              DelayedAnimation(
                child: InkWell(
                  onTap: () {
                    _uiBloc.state['navigatorKey'].currentState
                        .pushNamed('/login');
                  },
                  child: Text(
                    "ZATEN BİR HESABIM VAR".toUpperCase(),
                    style: TextStyle(
                        fontSize: 20.0,
                        fontWeight: FontWeight.bold,
                        color: color),
                  ),
                ),
                delay: delayedAmount + 5000,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget get _animatedButtonUI => InkWell(
        onTap: () {
          _uiBloc.state['navigatorKey'].currentState.pushNamed('/register');
        },
        child: Container(
          height: 60,
          width: 270,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(100.0),
            color: Colors.white,
          ),
          child: Center(
            child: Text(
              "Kayıt Ol",
              style: TextStyle(
                fontSize: 20.0,
                fontWeight: FontWeight.bold,
                color: Color(0xFF8185E2),
              ),
            ),
          ),
        ),
      );

  void _onTapDown(TapDownDetails details) {
    _controller.forward();
  }

  void _onTapUp(TapUpDetails details) {
    _controller.reverse();
  }
}
