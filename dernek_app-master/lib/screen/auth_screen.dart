import 'package:dernek_app/component/loading.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/api/index.dart' as Api;
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/bin/atom.dart' as atom;

class AuthScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _AuthScreenState();
}

class _AuthScreenState extends State<AuthScreen> {
  GlobalKey _scaffoldKey = GlobalKey<ScaffoldState>();

  Bloc.DeviceBloc _deviceBloc;
  Bloc.UIBloc _uiBloc;
  Bloc.UserBloc _userBloc;

  SharedPreferences _storage;

  @override
  void initState() {
    super.initState();
    // UI
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // Device
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    // User
    _userBloc = BlocProvider.of<Bloc.UserBloc>(context);
    // Ayarları al
    getSetting().then((value) {
      // Giriş kontrolünü yap
      if (_storage.getString('token') != null) {
        // Token varsa kontrolünü sağla
        Api.profile(token: _storage.getString('token')).then((profileResult) {
          print(profileResult);
          // Eğer başarılı değilse
          if (!profileResult['type'])
            return _uiBloc.add(Bloc.NavigateTo(route: '/landing'));
          // Kullanıcı bilgilerini düzenle
          _userBloc.add(Bloc.SetUser(
            children: profileResult['data']['childs']
                .map(
                  (child) => {
                    "name": child["name"],
                    "surname": child["surname"],
                    "birth": child["birth_date"],
                    "maritalStatus": child["marital_status"],
                    "job": child["job"],
                    "bloodGroup": child["blood_group"],
                    "phone": child["phone_number"],
                    "study": child["education_status"],
                  },
                )
                .toList(),
            phone: profileResult['data']['phone_number'],
            tc: profileResult['data']['tc_id'],
            email: profileResult['data']['email'],
            name: profileResult['data']['name'],
            surname: profileResult['data']['surname'],
            birth: profileResult['data']['birth_date'],
            study: profileResult['data']['education_status'],
            job: profileResult['data']['job'],
            bloodGroup: profileResult['data']['blood_group'],
            fatherName: profileResult['data']['father_name'],
            motherName: profileResult['data']['mother_name'],
            motherFatherName: profileResult['data']['mothers_father_name'],
            nickName: profileResult['data']['village_nickname'],
            villageNeighborhood: profileResult['data']['village_neighborhood'],
            homeAddress: profileResult['data']['home_address'],
            homePhone: profileResult['data']['home_phone'],
            businessAddress: profileResult['data']['job_address'],
            businessPhone: profileResult['data']['job_phone'],
            wifeName: profileResult['data']['spouse_name'],
            wifeBloodGroup: profileResult['data']['spouse_blood_group'],
            wifeFatherName: profileResult['data']['spouse_father'],
          ));
          print('Kullanıcı bilgileri alındı.');
          // Token onaylandı yönlendir anasayfaya
          _uiBloc.add(Bloc.NavigateUntilTo(route: '/home'));
        }).catchError(
          (err) => _uiBloc.add(Bloc.NavigateUntilTo(route: '/landing')),
        );
      } else
        _uiBloc.add(Bloc.NavigateUntilTo(route: '/landing'));
    }).catchError(
      (err) => _uiBloc.add(Bloc.AddSnackBar(
        type: 'error',
        message: 'Uygulama içi hata meydana geldi.',
      )),
    );
  }

  Future<void> getSetting() async {
    _storage = await atom.getStorage();
    _deviceBloc.add(Bloc.SetStorage(_storage));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      body: Loading(),
    );
  }
}
