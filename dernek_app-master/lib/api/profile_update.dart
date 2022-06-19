import 'dart:convert';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:http/http.dart' as http;

Future<Map> profileUpdate({
  token,
  children,
  name,
  surname,
  tc,
  birth,
  study,
  job,
  bloodGroup,
  phone,
  fatherName,
  motherName,
  motherFatherName,
  nickName,
  villageNeighborhood,
  homeAddress,
  homePhone,
  email,
  businessAddress,
  businessPhone,
  wifeName,
  wifeBloodGroup,
  wifeFatherName,
}) async {
  var _body = {
    'type': 'update',
    'tc_id': tc,
    'email': email,
    'name': name,
    'surname': surname,
    'birth_date': birth,
    'education_status': study,
    'job': job,
    'blood_group': bloodGroup,
    'father_name': fatherName,
    'mother_name': motherName,
    'mothers_father_name': motherFatherName,
    'village_nickname': nickName,
    'village_neighborhood': villageNeighborhood,
    'home_address': homeAddress,
    'home_phone': homePhone,
    'job_address': businessAddress,
    'job_phone': businessPhone,
    'spouse_name': wifeName,
    'spouse_blood_group': wifeBloodGroup,
    'spouse_father': wifeFatherName,
    'phone_number': phone,
    'childrens': children
        .map((child) => {
              "name": child["name"],
              "surname": child["surname"],
              "birth_date": child["birth"],
              "marital_status": child["maritalStatus"],
              "job": child["job"],
              "blood_group": child["bloodGroup"],
              "phone_number": child["phone"],
              "education_status": child["study"],
            })
        .toList(),
  };
  var apiResponse = await http.post(
    '${config.apiUrl}/Profile',
    body: JsonEncoder().convert(_body),
    headers: {'Authorization': token},
  );
  return apiResponse.statusCode == 200
      ? jsonDecode(apiResponse.body)
      : {
          'type': false,
          'message': "Sistemsel bir hata meydana geldi.",
          'data': null
        };
}
