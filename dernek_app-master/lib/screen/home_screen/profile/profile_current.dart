import 'package:email_validator/email_validator.dart';
import 'package:flutter/material.dart';
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:flutter/services.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:flutter_datetime_picker/flutter_datetime_picker.dart';
import 'package:flutter_masked_text/flutter_masked_text.dart';
import 'package:dernek_app/screen/home_screen/profile/init.dart' as init;

class ProfileCurrent extends StatefulWidget {
  Function profileUpdate;
  ProfileCurrent({this.profileUpdate});

  @override
  State<StatefulWidget> createState() =>
      _ProfileCurrentState(profileUpdate: profileUpdate);
}

class _ProfileCurrentState extends State {
  Function profileUpdate;
  _ProfileCurrentState({this.profileUpdate});
  List _currentChildren = [];
  final _currentName = TextEditingController();
  final _currentTC = TextEditingController();
  final _currentBirth = TextEditingController();
  String _currentStudy;
  final _currentJob = TextEditingController();
  String _currentBloodGroup;
  final _currentFatherName = TextEditingController();
  final _currentMotherName = TextEditingController();
  final _currentMotherFatherName = TextEditingController();
  final _currentNickName = TextEditingController();
  final _currentVillageNeighborhood = TextEditingController();
  final _currentHomeAddress = TextEditingController();
  final _currentHomePhone = MaskedTextController(
      text: '',
      mask: "+90 (###) ### ####",
      translator: {"#": RegExp(r'[0-9]')});
  final _currentEmail = TextEditingController();
  final _currentPhone = MaskedTextController(
      text: '',
      mask: "+90 (###) ### ####",
      translator: {"#": RegExp(r'[0-9]')});
  final _currentBusinessAddress = TextEditingController();
  final _currentBusinessPhone = MaskedTextController(
      text: '',
      mask: "+90 (###) ### ####",
      translator: {"#": RegExp(r'[0-9]')});
  final _currentWifeName = TextEditingController();
  String _currentWifeBloodGroup;
  final _currentWifeFatherName = TextEditingController();

  // Bloc
  Bloc.UIBloc _uiBloc;
  Bloc.UserBloc _userBloc;

  Map<String, dynamic> _userData;

  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // UserBloc
    _userBloc = BlocProvider.of<Bloc.UserBloc>(context);
    _userData = _userBloc.state;
    _currentName.text =
        "${_userData["name"]} ${_userData["surname"]}"; // Adı soyadı
    _currentPhone.updateText(_userData["phone"]); // telefon
    _currentBusinessPhone.updateText(_userData["businessPhone"]); // İş telefonu
    _currentHomePhone.updateText(_userData["homePhone"]); //Ev telefonu
    _currentChildren = _userData['children']; //Çocuklar
    _currentTC.text = _userData['tc']; // TC
    _currentBirth.text = _userData['birth']; // Doğum
    _currentStudy = _userData['study']; // Tahsili
    _currentJob.text = _userData['job']; // Meslek
    _currentBloodGroup = _userData['bloodGroup']; // Kan grubu
    _currentFatherName.text = _userData['fatherName']; // Baba adı
    _currentMotherName.text = _userData['motherName']; // Anne Adı
    _currentMotherFatherName.text =
        _userData['motherFatherName']; // Annesi kimin kızı
    _currentNickName.text = _userData['nickName']; // Lakabı
    _currentVillageNeighborhood.text =
        _userData['villageNeighborhood']; // Köy mahallesi
    _currentHomeAddress.text = _userData['homeAddress']; // Ev Adresi
    _currentEmail.text = _userData['email']; // Email
    _currentBusinessAddress.text = _userData['businessAddress']; // İş Adresi
    _currentWifeName.text = _userData['wifeName']; // Eş adı
    _currentWifeBloodGroup = _userData['wifeBloodGroup']; // Eş Kan grubu
    _currentWifeFatherName.text = _userData["wifeFatherName"]; // Eş kimin kızı
  }

  changedDropDownItem(String selected, int index) {
    setState(() {
      switch (index) {
        case 1:
          return _currentStudy = selected;
        case 2:
          return _currentBloodGroup = selected;
        case 3:
          return _currentWifeBloodGroup = selected;
      }
    });
  }

  final _form = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.only(top: 20, left: 15, right: 15, bottom: 15),
          child: Form(
            key: _form,
            child: Column(
              children: <Widget>[
                // Adı Soyadı
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentName,
                    enabled: false,
                    decoration: InputDecoration(
                      labelText: "Adı Soyadı",
                      prefixIcon: Icon(Icons.person),
                      // border:
                      //     new OutlineInputBorder(borderSide: new BorderSide()),
                    ),
                  ),
                ),
                // TC Kimlik Numarası
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                      controller: _currentTC,
                      decoration: InputDecoration(
                        labelText: "Tc Kimlik Numarası",
                        prefixIcon: Icon(Icons.assignment_ind),
                      ),
                      keyboardType: TextInputType.number,
                      validator: (value) {
                        if (value.isEmpty)
                          return "TC kimlik numarasınızı boş bırakmayınız";
                        else if (value.length != 11 && value.length > 0)
                          return "Tc Kimlik Numarasını 11 haneli giriniz";
                        return null;
                      }),
                ),
                // Doğum Tarihi
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: GestureDetector(
                    onTap: () {
                      DatePicker.showDatePicker(
                        context,
                        showTitleActions: true,
                        minTime: DateTime(1930, 1, 1),
                        maxTime: DateTime(2020, 12, 31),
                        onConfirm: (date) =>
                            _currentBirth.text = init.dateToGGMMYY(date),
                        currentTime: DateTime.now(),
                        locale: LocaleType.tr,
                      );
                    },
                    child: AbsorbPointer(
                      child: TextFormField(
                        decoration: InputDecoration(
                          labelText: 'Doğum Tarihiniz',
                          prefixIcon: Icon(Icons.date_range),
                        ),
                        controller: _currentBirth,
                        validator: (value) => value.isEmpty
                            ? "Doğum tarihinizi boş bırakmayınız"
                            : null,
                      ),
                    ),
                  ),
                ),
                // Tahsili
                Container(
                  padding: EdgeInsets.all(8),
                  width: double.infinity,
                  child: DropdownButtonFormField(
                    decoration: InputDecoration(
                      labelText: "Tahsili",
                      prefixIcon: Icon(Icons.school),
                    ),
                    value: _currentStudy,
                    items: init.dropDownMenuItems,
                    onChanged: (value) => changedDropDownItem(value, 1),
                    validator: (value) => value == null || value.isEmpty
                        ? "Tahsili boş bırakmayınız"
                        : null,
                  ),
                ),
                // Mesleği
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentJob,
                    decoration: InputDecoration(
                      labelText: "Mesleği",
                      prefixIcon: Icon(Icons.work),
                    ),
                    validator: (value) =>
                        value.isEmpty ? "Mesleği boş bırakmayınız" : null,
                  ),
                ),
                // Kan grubu
                Padding(
                  padding: EdgeInsets.all(8.0),
                  child: Container(
                    width: double.infinity,
                    child: DropdownButtonFormField(
                      decoration: InputDecoration(
                        labelText: "Kan Grubu",
                        prefixIcon: Icon(Icons.opacity),
                      ),
                      value: _currentBloodGroup,
                      items: init.dropDownMenuItems2,
                      onChanged: (value) => changedDropDownItem(value, 2),
                      validator: (value) => value == null || value.isEmpty
                          ? "Kan grubunu boş bırakmayınız"
                          : null,
                    ),
                  ),
                ),
                // Baba Adı
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentFatherName,
                    decoration: InputDecoration(
                      labelText: "Baba Adı",
                      prefixIcon: Icon(Icons.people),
                    ),
                    validator: (value) =>
                        value.isEmpty ? "Baba adını boş bırakmayınız" : null,
                  ),
                ),
                // Anne Adı
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentMotherName,
                    decoration: InputDecoration(
                      labelText: "Anne Adı",
                      prefixIcon: Icon(Icons.people),
                    ),
                    validator: (value) =>
                        value.isEmpty ? "Anne adını boş bırakmayınız" : null,
                  ),
                ),
                // Anne evlenmeden önce kimin kızı
                Container(
                  margin: EdgeInsets.only(left: 20.0),
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentMotherFatherName,
                    decoration: InputDecoration(
                      labelText: "Anne evlenmeden önce kimin kızı",
                      prefixIcon: Icon(Icons.person),
                    ),
                    validator: (value) => value.isEmpty
                        ? "Anne evlenmeden önce kimin kızı boş bırakmayınız"
                        : null,
                  ),
                ),
                // Köydeki Lakabı
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentNickName,
                    decoration: InputDecoration(
                      labelText: "Köydeki Lakabı",
                      prefixIcon: Icon(Icons.people),
                    ),
                    validator: (value) => value.isEmpty
                        ? "Köydeki Lakabını boş bırakmayınız"
                        : null,
                  ),
                ),
                // Köydeki Mahallesi
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentVillageNeighborhood,
                    decoration: InputDecoration(
                      labelText: "Köydeki Mahallesi",
                      prefixIcon: Icon(Icons.home),
                    ),
                    validator: (value) => value.isEmpty
                        ? "Köydeki Mahallesini boş bırakmayınız"
                        : null,
                  ),
                ),
                // Ev Adresi
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentHomeAddress,
                    decoration: InputDecoration(
                      labelText: "Ev Adresi",
                      prefixIcon: Icon(Icons.home),
                    ),
                    validator: (value) => value.isEmpty
                        ? "Köydeki Mahallesini boş bırakmayınız"
                        : null,
                  ),
                ),
                // E-Posta
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentEmail,
                    decoration: InputDecoration(
                      labelText: "E-Posta",
                      prefixIcon: Icon(Icons.email),
                    ),
                    validator: (value) => value.isNotEmpty
                        ? EmailValidator.validate(value)
                            ? null
                            : "E-Posta adresinizi kontrol edin"
                        : null,
                  ),
                ),
                // İş Adresi
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentBusinessAddress,
                    decoration: InputDecoration(
                      labelText: "İş Adresi",
                      prefixIcon: Icon(Icons.home),
                    ),
                  ),
                ),
                // İş Telefonu
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentBusinessPhone,
                    decoration: InputDecoration(
                      labelText: "İş Telefon",
                      prefixIcon: Icon(Icons.phone),
                    ),
                    keyboardType: TextInputType.number,
                  ),
                ),
                // Ev Telefonu
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentHomePhone,
                    decoration: InputDecoration(
                      labelText: "Ev Telefon",
                      prefixIcon: Icon(Icons.phone),
                    ),
                    keyboardType: TextInputType.number,
                  ),
                ),
                // Telefon Numaranız
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentPhone,
                    enabled: false,
                    decoration: InputDecoration(
                      labelText: "Telefon Numaranız",
                      prefixIcon: Icon(Icons.phone),
                    ),
                  ),
                ),
                // Eşinin Adı
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentWifeName,
                    decoration: InputDecoration(
                      labelText: "Eşinin Adı",
                      prefixIcon: Icon(Icons.people),
                    ),
                    validator: (value) =>
                        value.isEmpty ? "Eşinin adını boş bırakmayınız" : null,
                  ),
                ),
                // Eş Kan Grubu
                Padding(
                  padding: EdgeInsets.all(8.0),
                  child: Container(
                    width: double.infinity,
                    child: DropdownButtonFormField(
                      decoration: InputDecoration(
                        labelText: "Eş Kan Grubu",
                        prefixIcon: Icon(Icons.opacity),
                      ),
                      value: _currentWifeBloodGroup,
                      items: init.dropDownMenuItems2,
                      onChanged: (value) => changedDropDownItem(value, 3),
                      validator: (value) => value == null || value.isEmpty
                          ? "Eş kan grubunu boş bırakmayınız"
                          : null,
                    ),
                  ),
                ),
                // Evlenmeden önce kimin kızı
                Container(
                  margin: EdgeInsets.only(left: 20),
                  padding: EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _currentWifeFatherName,
                    decoration: InputDecoration(
                      labelText: "Evlenmeden önce kimin kızı",
                      prefixIcon: Icon(Icons.person_outline),
                    ),
                    validator: (value) => value.isEmpty
                        ? "Evlenmeden önce kimin kızı boş bırakmayınız"
                        : null,
                  ),
                ),
                // Çizgi
                Divider(),
                // Çocuklar
                Padding(
                  padding: EdgeInsets.all(8.0),
                  child: Container(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: <Widget>[
                        Text(
                          "Çocuklar",
                          style: TextStyle(
                            fontSize: 20.0,
                            color: Colors.black54,
                          ),
                        ),
                        Padding(
                          padding: EdgeInsets.all(10),
                          child: Column(
                            children: _getChildren(),
                          ),
                        ),
                      ],
                    ),
                    width: double.infinity,
                  ),
                ),
                Padding(
                  padding: EdgeInsets.all(8.0),
                  child: Container(
                    child: Align(
                      alignment: Alignment.topRight,
                      child: RaisedButton(
                        color: theme.color,
                        child: Text(
                          "+ Çocuk ekle",
                          style: TextStyle(
                            fontSize: 15.0,
                            color: theme.backgroundColor,
                          ),
                        ),
                        onPressed: () => init
                            .showModal(
                              context: context,
                              children: _currentChildren,
                            )
                            .then((result) => setState(() => null)),
                      ),
                    ),
                  ),
                ),
                // Kaydet
                Container(
                  padding: EdgeInsets.all(8.0),
                  child: ButtonTheme(
                    minWidth: double.infinity,
                    child: MaterialButton(
                      onPressed: () {
                        // Validation işlemi doğruysa profili güncelle
                        if (_form.currentState.validate()) {
                          profileUpdate(
                            currentChildren: _currentChildren,
                            currentName: _userData['name'],
                            currentSurname: _userData['surname'],
                            currentTC: _currentTC.text,
                            currentBirth: _currentBirth.text,
                            currentStudy: _currentStudy,
                            currentJob: _currentJob.text,
                            currentBloodGroup: _currentBloodGroup,
                            currentPhone:
                                init.phoneMaskToPhone(_currentPhone.text),
                            currentFatherName: _currentFatherName.text,
                            currentMotherName: _currentMotherName.text,
                            currentMotherFatherName:
                                _currentMotherFatherName.text,
                            currentNickName: _currentNickName.text,
                            currentVillageNeighborhood:
                                _currentVillageNeighborhood.text,
                            currentHomeAddress: _currentHomeAddress.text,
                            currentHomePhone: _currentHomePhone.text.isNotEmpty
                                ? init.phoneMaskToPhone(_currentHomePhone.text)
                                : '',
                            currentEmail: _currentEmail.text,
                            currentBusinessAddress:
                                _currentBusinessAddress.text,
                            currentBusinessPhone:
                                _currentBusinessPhone.text.isNotEmpty
                                    ? init.phoneMaskToPhone(
                                        _currentBusinessPhone.text)
                                    : '',
                            currentWifeName: _currentWifeName.text,
                            currentWifeBloodGroup: _currentWifeBloodGroup,
                            currentWifeFatherName: _currentWifeFatherName.text,
                          );
                        }
                      },
                      textColor: theme.lightColor,
                      hoverColor: theme.backgroundColor,
                      splashColor: theme.backgroundActiveColor,
                      color: theme.color,
                      child: Text(
                        "Güncelle",
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

  // Çocukların listesi
  List<Widget> _getChildren() {
    List<Widget> _children = [];
    for (int i = 0; i < _currentChildren.length; i++) {
      _children.add(Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: <Widget>[
          Text(_currentChildren[i]["name"].toString()),
          Row(
            children: <Widget>[
              IconButton(
                icon: Icon(Icons.edit, color: Colors.black54),
                onPressed: () {
                  init
                      .showModal(
                        context: context,
                        children: _currentChildren,
                        editIndex: i,
                      )
                      .then((result) => setState(() => null));
                },
              ),
              IconButton(
                icon: Icon(Icons.delete, color: Colors.black54),
                onPressed: () {
                  showDialog(
                    context: context,
                    builder: (context) => AlertDialog(
                      title: Text("Çocuğu siliyorsunuz"),
                      content: Text(
                          "'${_currentChildren[i]["name"]}' silmek istediğinize emin misiniz?"),
                      actions: <Widget>[
                        FlatButton(
                          child: Text("İptal"),
                          onPressed: () => Navigator.pop(context),
                        ),
                        FlatButton(
                          child: Text("Onayla"),
                          onPressed: () => setState(() {
                            _currentChildren.removeAt(i);
                            Navigator.pop(context);
                          }),
                        )
                      ],
                    ),
                  );
                },
              ),
            ],
          )
        ],
      ));
    }
    return _children;
  }
}
