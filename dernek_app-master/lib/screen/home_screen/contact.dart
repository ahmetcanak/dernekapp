import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bin/atom.dart' as atom;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/api/index.dart' as Api;
import 'package:image_picker/image_picker.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Contact extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _ContactState();
}

class _ContactState extends State<Contact> {
  GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  // Form
  TextEditingController _currentSubject = TextEditingController();
  TextEditingController _currentMessage = TextEditingController();

  // Bloc
  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;

  SharedPreferences _storage;
  String _token;

  File _image;

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
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.only(top: 20, left: 15, right: 15, bottom: 15),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Text(
                  "* işaretli alanlar zorunlu alanlardır.",
                  style: TextStyle(color: Colors.grey[600]),
                ),
                // Konu
                Container(
                  padding: EdgeInsets.only(top: 10, bottom: 20),
                  child: TextFormField(
                    controller: _currentSubject,
                    decoration: InputDecoration(
                      labelText: "Konu *",
                    ),
                    validator: (value) {
                      if (value.isEmpty)
                        return "Konuyu doldurun";
                      else if (value.length < 5)
                        return "Konu en az 5 karakter olmalıdır";
                      else if (value.length > 64)
                        return "Konu en fazla 64 karakter olmalıdır";
                      return null;
                    },
                  ),
                ),
                // Açıklama
                Container(
                  padding: EdgeInsets.only(bottom: 20),
                  child: TextFormField(
                    controller: _currentMessage,
                    maxLines: null,
                    keyboardType: TextInputType.multiline,
                    minLines: 4,
                    decoration: InputDecoration(labelText: "Açıklama *"),
                    validator: (value) {
                      if (value.isEmpty)
                        return "Açıklamayı doldurun";
                      else if (value.length < 10)
                        return "Açıklama en az 10 karakter olmalıdır";
                      else if (value.length > 500)
                        return "Açıklama en fazla 500 karakter olmalıdır";
                      return null;
                    },
                  ),
                ),
                // Fotoğraf yükleme alanı
                Container(
                  width: atom.screenWidthPercent(context: context),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      Padding(
                        padding: EdgeInsets.only(bottom: 10),
                        child: Text(
                          "Fotoğraf",
                          style: TextStyle(color: Colors.grey[600]),
                        ),
                      ),
                      Card(
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10.0),
                        ),
                        color: theme.backgroundActiveColor,
                        child: Container(
                          height: 200,
                          width: atom.screenWidthPercent(
                            context: context,
                            percent: 100,
                          ),
                          child: InkWell(
                            // Resim Yükle ve Hata yakala
                            onTap: () => getImage().catchError(
                              (err) => _uiBloc.add(Bloc.AddSnackBar(
                                type: 'error',
                                message: 'Fotoğraf için izin gereklidir',
                              )),
                            ),
                            child: _image == null
                                ? Padding(
                                    padding:
                                        EdgeInsets.only(top: 70, bottom: 70),
                                    child: CircleAvatar(
                                      backgroundColor: theme.color,
                                      child: ClipOval(
                                        child: Icon(Icons.add,
                                            color: theme.lightColor),
                                      ),
                                    ),
                                  )
                                : Image.file(_image),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                // Mesaj gönder butonu
                Container(
                  padding: EdgeInsets.only(top: 20),
                  child: ButtonTheme(
                    minWidth: double.infinity,
                    child: MaterialButton(
                      onPressed: sendContact,
                      textColor: theme.lightColor,
                      hoverColor: theme.backgroundColor,
                      splashColor: theme.backgroundActiveColor,
                      color: theme.color,
                      child: Text(
                        "Mesajınızı Gönderin",
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  sendContact() {
    if (_formKey.currentState.validate())
      Api.message(
              token: _token,
              subject: _currentSubject.text,
              message: _currentMessage.text,
              image: _image)
          .then((messageResult) {
        _uiBloc.add(Bloc.AddSnackBar(
          type: messageResult['type'] ? 'success' : 'error',
          message: messageResult['message'],
        ));
        if (!messageResult['type']) return;
        _currentMessage.clear();
        _currentSubject.clear();
      }).catchError(
        (err) {
          print(err);
          return _uiBloc.add(Bloc.AddSnackBar(
            type: 'error',
            message: 'Uygulama içi hata meydana geldi.',
          ));
        },
      );
  }

  // Fotoğraf Seç
  Future getImage() async {
    var image = await ImagePicker.pickImage(source: ImageSource.gallery);
    setState(() {
      _image = image;
    });
  }
}
