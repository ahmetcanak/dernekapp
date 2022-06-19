import 'package:dernek_app/component/loading.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/api/index.dart' as Api;

class Notifications extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _NotificationsState();
}

class _NotificationsState extends State<Notifications> {
  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  // Bloc
  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;

  SharedPreferences _storage;
  String _token;

  bool _newLoading = true;
  List _notifications = [];

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // DeviceBloc
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
    _token = _storage.getString('token');
    // Bildirimleri al
    Api.notifications(token: _token).then((notificationsResult) {
      if (!notificationsResult['type'])
        return _uiBloc.add(Bloc.AddSnackBar(
          type: 'error',
          message: notificationsResult['message'],
        ));
      setState(() {
        _newLoading = false;
      });
      _notifications = notificationsResult['data'];
    }).catchError(
      (err) => _uiBloc.add(Bloc.AddSnackBar(
        type: 'error',
        message: 'Sistemsel bir hata meydana geldi.',
      )),
    );
  }

  @override
  Widget build(BuildContext context) {
    return _newLoading
        ? Loading()
        : Scaffold(
            key: _scaffoldKey,
            body: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.only(top: 9.0, left: 5.0, right: 5.0),
                child: _getNotifications(),
              ),
            ),
          );
  }

  Widget _getNotifications() {
    List<Widget> _notificationList = [];
    for (var _notification in _notifications)
      _notificationList.add(notificationBuilder(
        title: _notification['title'],
        text: _notification['text'],
        image: _notification['image'],
        time: _notification['sended_time'],
      ));
    return Column(children: _notificationList);
  }

  Padding notificationBuilder({title, text, image, time}) {
    return Padding(
      padding: const EdgeInsets.all(3.0),
      child: Container(
        decoration: BoxDecoration(
          border: Border.all(color: theme.color.withOpacity(1), width: 2.0),
          borderRadius: BorderRadius.circular(6.0),
          color: Colors.white,
        ),
        child: ListTile(
          leading: CircleAvatar(
            backgroundColor: theme.color,
            child: image == null
                ? Icon(Icons.notifications_active, color: Colors.white)
                : Image.network(
                    image,
                    fit: BoxFit.cover,
                  ),
          ),
          title: Text(title),
          subtitle: Text(text),
        ),
      ),
    );
  }
}
