import 'package:flutter/material.dart';
import 'package:dernek_app/screen/home_screen/profile/profile_current.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/api/index.dart' as Api;
import 'package:shared_preferences/shared_preferences.dart';

class Profile extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> with SingleTickerProviderStateMixin {
  List currentChildren = [
    {
      "name": "Bayram",
      "surname": "Alaçam",
      "birth": "10/01/2000",
      "maritalStatus": "Bekar",
      "job": "Yazılım Uzmanı",
      "study": "Lise",
      "bloodGroup": "B+",
      "phone": "5349370192"
    },
    {
      "name": "Emirhan",
      "surname": "Alaçam",
      "birth": "02/03/2002",
      "maritalStatus": "Bekar",
      "job": "Elektrik & Elektronik",
      "study": "Lise",
      "bloodGroup": "B+",
      "phone": "5370993322",
    },
  ]; // Çocukları
  String currentTC = "19809809867"; // TC
  String currentName = "Bayram"; // Adı
  String currentSurname = "Alaçam"; // Soyadı
  String currentBirth = "10/01/2000"; // Doğum Tarigi
  String currentStudy = "Lise"; // Öğrenim
  String currentJob = "Yazılım Uzmanı"; // Mesleği
  String currentBloodGroup = "B+"; // Kan grubu
  String currentFatherName = "BBaba"; // Baba Adı
  String currentMotherName = "BAnne"; // Anne adı
  String currentMotherFatherName = "ABBaba"; // Annesinin Babasının Adı
  String currentNickName = "Lakapp"; // Lakabı
  String currentVillageNeighborhood = "Cuma"; // Köydeki Mahallesi
  String currentHomeAddress = "Istanbul"; // Ev Adresi
  String currentEmail = "bayramlcm14@gmail.com"; // E-Posta
  String currentBusinessAddress = "Sakarya"; // İş Adresi
  String currentBusinessPhone = "2163541394"; // İş Telefonu
  String currentHomePhone = "2169998877"; // Ev Telefonu
  String currentPhone = "5349370192"; // Telefon numarası
  String currentWifeName = "Biricik"; // Eşinin adı
  String currentWifeBloodGroup = "A+"; // Eşinin kan grubu
  String currentWifeFatherName = "EBaba"; // Eşinin babasının adı

  Bloc.DeviceBloc _deviceBloc;
  Bloc.UserBloc _userBloc;
  Bloc.UIBloc _uiBloc;

  SharedPreferences _storage;
  String _token;

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    // DeviceBloc
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
    _token = _storage.getString('token');
    // UserBloc
    _userBloc = BlocProvider.of<Bloc.UserBloc>(context);
  }

  @override
  Widget build(BuildContext context) {
    return ProfileCurrent(
      profileUpdate: profileUpdate,
    );
  }

  // Profili Kaydet
  void profileUpdate({
    currentChildren,
    currentTC,
    currentName,
    currentSurname,
    currentBirth,
    currentStudy,
    currentJob,
    currentBloodGroup,
    currentPhone,
    currentFatherName,
    currentMotherName,
    currentMotherFatherName,
    currentNickName,
    currentVillageNeighborhood,
    currentHomeAddress,
    currentHomePhone,
    currentEmail,
    currentBusinessAddress,
    currentBusinessPhone,
    currentWifeName,
    currentWifeBloodGroup,
    currentWifeFatherName,
  }) {
    Api.profileUpdate(
      token: _token,
      children: currentChildren,
      name: currentSurname,
      surname: currentName,
      tc: currentTC,
      birth: currentBirth,
      study: currentStudy,
      job: currentJob,
      bloodGroup: currentBloodGroup,
      phone: currentPhone,
      fatherName: currentFatherName,
      motherName: currentMotherName,
      motherFatherName: currentMotherFatherName,
      nickName: currentNickName,
      villageNeighborhood: currentVillageNeighborhood,
      homeAddress: currentHomeAddress,
      homePhone: currentHomePhone,
      email: currentEmail,
      businessAddress: currentBusinessAddress,
      businessPhone: currentBusinessPhone,
      wifeName: currentWifeName,
      wifeBloodGroup: currentWifeBloodGroup,
      wifeFatherName: currentWifeFatherName,
    ).then((profileUpdateResult) {
      _uiBloc.add(Bloc.AddSnackBar(
        type: profileUpdateResult['type'] ? 'success' : 'error',
        message: profileUpdateResult['message'],
      ));
      // Eğer başarılı değilse
      if (!profileUpdateResult['type']) return;
      // Verileri güncelle
      _userBloc.add(Bloc.SetUser(
          children: currentChildren,
          name: currentSurname,
          surname: currentName,
          tc: currentTC,
          birth: currentBirth,
          study: currentStudy,
          job: currentJob,
          bloodGroup: currentBloodGroup,
          phone: currentPhone,
          fatherName: currentFatherName,
          motherName: currentMotherName,
          motherFatherName: currentMotherFatherName,
          nickName: currentNickName,
          villageNeighborhood: currentVillageNeighborhood,
          homeAddress: currentHomeAddress,
          homePhone: currentHomePhone,
          email: currentEmail,
          businessAddress: currentBusinessAddress,
          businessPhone: currentBusinessPhone,
          wifeName: currentWifeName,
          wifeBloodGroup: currentWifeBloodGroup,
          wifeFatherName: currentWifeFatherName));
    }).catchError(
      (err) => _uiBloc.add(Bloc.AddSnackBar(
        type: 'error',
        message: 'Uygulama içi hata meydana geldi.',
      )),
    );
  }
}
