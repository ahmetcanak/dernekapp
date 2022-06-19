import 'package:flutter/material.dart';
import 'package:flutter_datetime_picker/flutter_datetime_picker.dart';
import 'package:flutter_masked_text/flutter_masked_text.dart';
import 'package:dernek_app/screen/home_screen/profile/init.dart' as init;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;

class ProfileChild extends StatefulWidget {
  List children;
  int editIndex;
  ProfileChild({this.children, this.editIndex});
  @override
  State<StatefulWidget> createState() =>
      _ProfileChildState(children: children, editIndex: editIndex);
}

class _ProfileChildState extends State {
  List children;
  int editIndex;
  _ProfileChildState({this.children, this.editIndex});
  // Bloc
  Bloc.UIBloc _uiBloc;
  // Form
  final _form = GlobalKey<FormState>();
  final _currentName = TextEditingController();
  final _currentSurname = TextEditingController();
  final _currentMaritalStatus = TextEditingController();
  final _currentJob = TextEditingController();
  final _currentBirth = TextEditingController();
  String _currentStudy;
  String _currentBloodGroup;
  final _currentPhone = MaskedTextController(
      text: '',
      mask: "+90 (###) ### ####",
      translator: {"#": RegExp(r'[0-9]')});

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    // Güncelleme verisiyse yerleştir
    if (editIndex != -1) {
      _currentName.text = children[editIndex]['name'];
      _currentSurname.text = children[editIndex]['surname'];
      _currentMaritalStatus.text = children[editIndex]['maritalStatus'];
      _currentJob.text = children[editIndex]['job'];
      _currentBirth.text = children[editIndex]['birth'];
      _currentStudy = children[editIndex]['study'];
      _currentBloodGroup = children[editIndex]['bloodGroup'];
      children[editIndex]['phone'] != null && children[editIndex]['phone'] != ''
          ? _currentPhone.updateText(children[editIndex]['phone'])
          : null;
    }
  }

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: SafeArea(
        child: Padding(
          padding: EdgeInsets.only(
            left: 8,
            right: 8,
            top: 8,
            bottom: MediaQuery.of(context).viewInsets.bottom,
          ),
          child: Form(
            key: _form,
            child: Container(
                child: SingleChildScrollView(
              child: Column(
                children: <Widget>[
                  // Çocuk Adı
                  Container(
                    padding: EdgeInsets.all(8.0),
                    child: TextFormField(
                      controller: _currentName,
                      decoration: InputDecoration(
                        labelText: "Çocuk Adı",
                        prefixIcon: Icon(Icons.person),
                      ),
                      validator: (value) =>
                          value.isEmpty ? "Çocuk adını boş bırakmayınız" : null,
                    ),
                  ),
                  // Çocuk Soyadı
                  Container(
                    padding: EdgeInsets.all(8.0),
                    child: TextFormField(
                      controller: _currentSurname,
                      decoration: InputDecoration(
                        labelText: "Çocuk Soyadı",
                        prefixIcon: Icon(Icons.person),
                      ),
                      validator: (value) => value.isEmpty
                          ? "Çocuk soyadını boş bırakmayınız"
                          : null,
                    ),
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
                            labelText: 'Çocuk Doğum Tarihi',
                            prefixIcon: Icon(Icons.date_range),
                          ),
                          controller: _currentBirth,
                          validator: (value) => value.isEmpty
                              ? "Çocuk doğum tarihinizi boş bırakmayınız"
                              : null,
                        ),
                      ),
                    ),
                  ),
                  // Çocuk Medeni Durumu
                  Container(
                    padding: EdgeInsets.all(8.0),
                    child: TextFormField(
                      controller: _currentMaritalStatus,
                      decoration: InputDecoration(
                        labelText: "Çocuk Medeni Durum",
                        prefixIcon: Icon(Icons.group),
                      ),
                      validator: (value) => value.isEmpty
                          ? "Çocuk medeni durumu boş bırakmayınız"
                          : null,
                    ),
                  ),
                  // Çocuk Meslek
                  Container(
                    padding: EdgeInsets.all(8.0),
                    child: TextFormField(
                      controller: _currentJob,
                      decoration: InputDecoration(
                        labelText: "Çocuk Meslek",
                        prefixIcon: Icon(Icons.work),
                      ),
                      validator: (value) => value.isEmpty
                          ? "Çocuk mesleği boş bırakmayınız"
                          : null,
                    ),
                  ),
                  // Çocuk Tahsili
                  Container(
                    padding: EdgeInsets.all(8),
                    width: double.infinity,
                    child: DropdownButtonFormField(
                      decoration: InputDecoration(
                        labelText: "Çocuk Tahsili",
                        prefixIcon: Icon(Icons.school),
                      ),
                      value: _currentStudy,
                      items: init.dropDownMenuItems,
                      onChanged: (value) => changedDropDownItem(value, 4),
                      validator: (value) => value == null || value.isEmpty
                          ? "Çocuk tahsili boş bırakmayınız"
                          : null,
                    ),
                  ),
                  // Çocuk Kan Grubu
                  Container(
                    width: double.infinity,
                    padding: EdgeInsets.all(8.0),
                    child: DropdownButtonFormField(
                      decoration: InputDecoration(
                        labelText: "Çocuk Kan Grubu",
                        prefixIcon: Icon(Icons.opacity),
                      ),
                      value: _currentBloodGroup,
                      items: init.dropDownMenuItems2,
                      onChanged: (value) => changedDropDownItem(value, 5),
                      validator: (value) => value == null || value.isEmpty
                          ? "Çocuk kan grubunu boş bırakmayınız"
                          : null,
                    ),
                  ),
                  // Çocuk Telefon
                  Container(
                    padding: EdgeInsets.all(8.0),
                    child: TextFormField(
                      controller: _currentPhone,
                      decoration: InputDecoration(
                        labelText: "Çocuk Telefon",
                        prefixIcon: Icon(Icons.phone),
                      ),
                      keyboardType: TextInputType.number,
                      validator: (value) => value.isNotEmpty
                          ? _currentPhone.text.length != 18
                              ? "Çocuk telefonu kontrol edin"
                              : null
                          : null,
                    ),
                  ),
                  // Butonlar
                  Container(
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: <Widget>[
                          RaisedButton(
                            child: Text(
                              "İptal",
                              style: TextStyle(color: Colors.white),
                            ),
                            onPressed: () => _uiBloc.add(Bloc.NavigatePop()),
                            color: theme.color,
                          ),
                          RaisedButton(
                            child: Text(
                              editIndex == -1 ? "Kaydet" : "Güncelle",
                              style: TextStyle(color: Colors.white),
                            ),
                            onPressed: () {
                              if (_form.currentState.validate()) {
                                Map _childData = {
                                  "name": _currentName.text,
                                  "surname": _currentSurname.text,
                                  "birth": _currentBirth.text,
                                  "maritalStatus": _currentMaritalStatus.text,
                                  "job": _currentJob.text,
                                  "study": _currentStudy,
                                  "bloodGroup": _currentBloodGroup,
                                  "phone": _currentPhone.text.isNotEmpty
                                      ? init
                                          .phoneMaskToPhone(_currentPhone.text)
                                      : "",
                                };
                                setState(() {
                                  editIndex == -1
                                      ? children.add(_childData)
                                      : children[editIndex] = _childData;
                                });
                                _uiBloc.add(Bloc.NavigatePop());
                              }
                            },
                            color: theme.color,
                          ),
                        ],
                      ),
                    ),
                  )
                ],
              ),
            )),
          ),
        ),
      ),
    );
  }

  changedDropDownItem(String selected, int index) {
    setState(() {
      switch (index) {
        case 4:
          return _currentStudy = selected;
        case 5:
          return _currentBloodGroup = selected;
      }
    });
  }
}
