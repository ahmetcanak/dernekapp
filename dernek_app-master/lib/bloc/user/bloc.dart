import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bin/atom.dart' as atom;
import 'package:dernek_app/bloc/user/index.dart';

class UserBloc extends Bloc<UserEvent, Map<String, dynamic>> {
  @override
  Map<String, dynamic> get initialState => {
        "children": [],
        "name": "",
        "surname": "",
        "tc": "",
        "birth": "",
        "study": null,
        "job": "",
        "bloodGroup": null,
        "phone": "",
        "fatherName": "",
        "motherName": "",
        "motherFatherName": "",
        "nickName": "",
        "villageNeighborhood": "",
        "homeAddress": "",
        "homePhone": "",
        "email": "",
        "businessAddress": "",
        "businessPhone": "",
        "wifeName": "",
        "wifeBloodGroup": null,
        "wifeFatherName": "",
      };

  @override
  Stream<Map<String, dynamic>> mapEventToState(UserEvent event) async* {
    if (event is SetUser) {
      yield atom.setState(state: state, newState: {
        "children": event.children == null ? [] : event.children,
        "name": event.name == null ? '' : event.name,
        "surname": event.surname == null ? '' : event.surname,
        "tc": event.tc == null ? '' : event.tc,
        "birth": event.birth == null ? '' : event.birth,
        "study": event.study,
        "job": event.job == null ? '' : event.job,
        "bloodGroup": event.bloodGroup,
        "phone": event.phone == null ? '' : event.phone,
        "fatherName": event.fatherName == null ? '' : event.fatherName,
        "motherName": event.motherName == null ? '' : event.motherName,
        "motherFatherName":
            event.motherFatherName == null ? '' : event.motherFatherName,
        "nickName": event.nickName == null ? '' : event.nickName,
        "villageNeighborhood":
            event.villageNeighborhood == null ? '' : event.villageNeighborhood,
        "homeAddress": event.homeAddress == null ? '' : event.homeAddress,
        "homePhone": event.homePhone == null ? '' : event.homePhone,
        "email": event.email == null ? '' : event.email,
        "businessAddress":
            event.businessAddress == null ? '' : event.businessAddress,
        "businessPhone": event.businessPhone == null ? '' : event.businessPhone,
        "wifeName": event.wifeName == null ? '' : event.wifeName,
        "wifeBloodGroup": event.wifeBloodGroup,
        "wifeFatherName":
            event.wifeFatherName == null ? '' : event.wifeFatherName,
      });
    }
  }
}
