import 'package:flutter/material.dart';
import 'package:dernek_app/component/fade_animation.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:mask_text_input_formatter/mask_text_input_formatter.dart';
import 'package:dernek_app/api/index.dart' as Api;
import 'package:shared_preferences/shared_preferences.dart';

class RegisterScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State {
  MaskTextInputFormatter _phoneMask = MaskTextInputFormatter(
      mask: '+90 (###) ### ####', filter: {"#": RegExp(r'[0-9]')});
  final _formKey = GlobalKey<FormState>();

  TextEditingController _name = TextEditingController();
  TextEditingController _surname = TextEditingController();
  TextEditingController _password = TextEditingController();
  bool _activeRegisterButton = true;

  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;
  Bloc.UserBloc _userBloc;

  SharedPreferences _storage;

  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  @override
  void initState() {
    super.initState();
    // UI
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // Device
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
    // User
    _userBloc = BlocProvider.of<Bloc.UserBloc>(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      backgroundColor: Colors.white,
      body: SingleChildScrollView(
        child: Container(
          child: Column(
            children: <Widget>[
              Container(
                height: 400,
                decoration: BoxDecoration(
                    image: DecorationImage(
                        image: AssetImage('assets/images/background.png'),
                        fit: BoxFit.fill)),
                child: Stack(
                  children: <Widget>[
                    Positioned(
                      left: 30,
                      width: 80,
                      height: 200,
                      child: FadeAnimation(
                          1,
                          Container(
                            decoration: BoxDecoration(
                                image: DecorationImage(
                                    image: AssetImage(
                                        'assets/images/light-1.png'))),
                          )),
                    ),
                    Positioned(
                      left: 140,
                      width: 80,
                      height: 150,
                      child: FadeAnimation(
                          1.3,
                          Container(
                            decoration: BoxDecoration(
                                image: DecorationImage(
                                    image: AssetImage(
                                        'assets/images/light-2.png'))),
                          )),
                    ),
                    Positioned(
                      right: 40,
                      top: 40,
                      width: 80,
                      height: 150,
                      child: FadeAnimation(
                          1.5,
                          Container(
                            decoration: BoxDecoration(
                                image: DecorationImage(
                                    image:
                                        AssetImage('assets/images/clock.png'))),
                          )),
                    ),
                    Positioned(
                      child: FadeAnimation(
                          1.6,
                          Container(
                            margin: EdgeInsets.only(top: 50),
                            child: Center(
                              child: Text(
                                "Kayıt Ol",
                                style: TextStyle(
                                    color: Colors.white,
                                    fontSize: 40,
                                    fontWeight: FontWeight.bold),
                              ),
                            ),
                          )),
                    )
                  ],
                ),
              ),
              Padding(
                padding: EdgeInsets.all(30.0),
                child: Column(
                  children: <Widget>[
                    FadeAnimation(
                      1.8,
                      Container(
                        padding: EdgeInsets.all(5),
                        decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(10),
                            boxShadow: [
                              BoxShadow(
                                  color: Color.fromRGBO(143, 148, 251, .2),
                                  blurRadius: 20.0,
                                  offset: Offset(0, 10))
                            ]),
                        child: Form(
                          key: _formKey,
                          child: Column(
                            children: <Widget>[
                              Container(
                                padding: EdgeInsets.all(8.0),
                                decoration: BoxDecoration(
                                    border: Border(
                                        bottom: BorderSide(
                                            color: Colors.grey[100]))),
                                child: TextFormField(
                                  controller: _name,
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Adınız",
                                    hintStyle: TextStyle(
                                      color: Colors.grey[400],
                                    ),
                                  ),
                                  validator: (value) {
                                    if (value.isEmpty)
                                      return "Adınızı boş bırakmayınız";
                                    else if (value.length < 2)
                                      return "Adınız en az 2 karakter olmalıdır";
                                    else if (value.length > 64)
                                      return "Adınız en fazla 64 karakter olmalıdır";
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                decoration: BoxDecoration(
                                    border: Border(
                                        bottom: BorderSide(
                                            color: Colors.grey[100]))),
                                child: TextFormField(
                                  controller: _surname,
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Soyadınız",
                                    hintStyle: TextStyle(
                                      color: Colors.grey[400],
                                    ),
                                  ),
                                  validator: (value) {
                                    if (value.isEmpty)
                                      return "Soyadınızı boş bırakmayınız";
                                    else if (value.length < 2)
                                      return "Soyadınız en az 2 karakter olmalıdır";
                                    else if (value.length > 64)
                                      return "Soyadınız en fazla 64 karakter olmalıdır";
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                decoration: BoxDecoration(
                                    border: Border(
                                        bottom: BorderSide(
                                            color: Colors.grey[100]))),
                                child: TextFormField(
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Telefon Numaranız",
                                    hintStyle: TextStyle(
                                      color: Colors.grey[400],
                                    ),
                                  ),
                                  keyboardType: TextInputType.number,
                                  inputFormatters: [_phoneMask],
                                  validator: (value) {
                                    String phone = _phoneMask.getUnmaskedText();
                                    if (phone.isEmpty)
                                      return "Telefonu boş bırakmayınız";
                                    else if (phone.length != 10)
                                      return "Telefon numaranızı eksiksiz giriniz";
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: _password,
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Şifreniz",
                                    hintStyle: TextStyle(
                                      color: Colors.grey[400],
                                    ),
                                  ),
                                  obscureText: true,
                                  validator: (value) {
                                    if (value.isEmpty)
                                      return "Şifreyi boş bırakmayınız";
                                    else if (value.length < 8)
                                      return "Şifre en az 8 karakter olmalıdır";
                                    else if (value.length > 64)
                                      return "Şifre en fazla 64 karakter olmalıdır";
                                    else if (value.length > 64) return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Şifreniz Tekrar",
                                    hintStyle: TextStyle(
                                      color: Colors.grey[400],
                                    ),
                                  ),
                                  obscureText: true,
                                  validator: (value) {
                                    if (value.isEmpty)
                                      return "Şifreyi boş bırakmayınız";
                                    else if (value.length < 8)
                                      return "Şifre en az 8 karakter olmalıdır";
                                    else if (value.length > 64)
                                      return "Şifre en fazla 64 karakter olmalıdır";
                                    else if (value != _password.text)
                                      return "Şifreleriniz uyuşmuyor";
                                    return null;
                                  },
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                    SizedBox(
                      height: 30,
                    ),
                    FadeAnimation(
                      2,
                      InkWell(
                        onTap: () {
                          // if (_formKey.currentState.validate())
                          register();
                        },
                        child: Container(
                          height: 50,
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(10),
                              gradient: LinearGradient(colors: [
                                Color.fromRGBO(143, 148, 251, 1),
                                Color.fromRGBO(143, 148, 251, .6),
                              ])),
                          child: Center(
                            child: Text(
                              "Kayıt Ol",
                              style: TextStyle(
                                  color: Colors.white,
                                  fontWeight: FontWeight.bold),
                            ),
                          ),
                        ),
                      ),
                    ),
                    SizedBox(
                      height: 70,
                    ),
                    FadeAnimation(
                      1.5,
                      InkWell(
                        onTap: () {
                          _uiBloc.state['navigatorKey'].currentState
                              .pushNamed('/login');
                        },
                        child: Text(
                          "Zaten hesabım var! Giriş yap",
                          style: TextStyle(
                            color: Color.fromRGBO(143, 148, 251, 1),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              )
            ],
          ),
        ),
      ),
    );
  }

  register() {
    // Eğer buton tıklanabiliyorsa
    if (_activeRegisterButton) {
      // Tıklanmasını kapat
      _activeRegisterButton = false;
      Api.register(
        name: _name.text,
        surname: _surname.text,
        phone: _phoneMask.getUnmaskedText(),
        password: _password.text,
      ).then(
        (registerResult) {
          // Buton tıklamasını aktifleştir
          _activeRegisterButton = true;
          // Kayıt başarısızsa
          if (!registerResult['type'])
            return _uiBloc.add(Bloc.AddSnackBar(
              type: 'error',
              message: registerResult['message'],
            ));
          // Kayıt başarılı tokenı kaydet
          _storage
              .setString('token', registerResult['data']['key'])
              .then((tokenStatus) {
            // Anasayfaya yönlendir
            _uiBloc.add(Bloc.NavigateUntilTo(route: '/'));
          });
        },
      ).catchError(
        (err) {
          _activeRegisterButton = true;
          _uiBloc.add(Bloc.AddSnackBar(
            type: 'error',
            message: "Uygulama içi bir hata meydana geldi.",
          ));
        },
      );
    } else
      _uiBloc.add(Bloc.AddSnackBar(
        type: "warning",
        message: "Lütfen bekleyiniz, kayıt olunuyor..",
      ));
  }
}
