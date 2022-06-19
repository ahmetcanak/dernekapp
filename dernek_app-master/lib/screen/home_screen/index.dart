import 'package:dernek_app/screen/home_screen/contact.dart';
import 'package:dernek_app/screen/home_screen/news/index.dart';
import 'package:dernek_app/screen/home_screen/notifications.dart';
import 'package:dernek_app/screen/home_screen/profile/index.dart';
import 'package:flutter/material.dart';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:bottom_navy_bar/bottom_navy_bar.dart';
import 'package:shared_preferences/shared_preferences.dart';

class HomeScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _HomeScreenState();
}

class _HomeScreenState extends State {
  int _currentIndex = 0;
  PageController _pageController;

  GlobalKey _scaffoldKey = GlobalKey<ScaffoldState>();

  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;

  SharedPreferences _storage;

  @override
  void initState() {
    super.initState();
    _pageController = PageController();
    // UI
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // Device
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
  }

  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      appBar: _navbar(),
      body: SizedBox.expand(
        child: PageView(
          controller: _pageController,
          onPageChanged: (index) {
            setState(() => _currentIndex = index);
          },
          children: <Widget>[
            News(),
            Profile(),
            Contact(),
            Notifications(),
          ],
        ),
      ),
      bottomNavigationBar: _bottomNavigationBar(),
    );
  }

  Widget _bottomNavigationBar() => BottomNavyBar(
        selectedIndex: _currentIndex,
        onItemSelected: (index) {
          setState(() => _currentIndex = index);
          _pageController.jumpToPage(index);
        },
        items: <BottomNavyBarItem>[
          BottomNavyBarItem(
            activeColor: theme.backgroundColor,
            title: Text('Haberler'),
            icon: Icon(Icons.library_books),
          ),
          BottomNavyBarItem(
            activeColor: theme.backgroundColor,
            title: Text('Profilim'),
            icon: Icon(Icons.perm_identity),
          ),
          BottomNavyBarItem(
            activeColor: theme.backgroundColor,
            title: Text('İletişim'),
            icon: Icon(Icons.mail_outline),
          ),
          BottomNavyBarItem(
            activeColor: theme.backgroundColor,
            title: Text('Bildirimler'),
            icon: Icon(Icons.notifications),
          ),
        ],
      );

  Widget _navbar() => AppBar(
        automaticallyImplyLeading: false,
        centerTitle: false,
        backgroundColor: theme.color,
        title: Text(config.appName),
        actions: <Widget>[
          IconButton(
              icon: Icon(
                Icons.power_settings_new,
                color: theme.backgroundColor,
              ),
              onPressed: () {
                // Çıkış yap
                showDialog(
                  context: context,
                  builder: (context) => AlertDialog(
                    title: Text("Çıkış Yapıyorsunuz"),
                    content: Text("Çıkış yapmak istediğinize emin misiniz?"),
                    actions: <Widget>[
                      FlatButton(
                        child: Text("HAYIR"),
                        onPressed: () => Navigator.pop(context),
                      ),
                      FlatButton(
                        child: Text("EVET"),
                        onPressed: () => setState(() {
                          // Token bilgilerini temizle ve landing'e yönlendir
                          _storage.setBool('token', null);
                          _uiBloc.add(Bloc.NavigateUntilTo(route: '/landing'));
                        }),
                      )
                    ],
                  ),
                );
              }),
        ],
      );
}
