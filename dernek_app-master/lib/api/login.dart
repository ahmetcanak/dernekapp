import 'dart:convert';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:http/http.dart' as http;

Future<Map> login({phone, password}) async {
  var _body = {
    'phone_number': phone,
    'password': password,
  };
  var apiResponse = await http.post(
    '${config.apiUrl}/Login',
    body: JsonEncoder().convert(_body),
  );
  return apiResponse.statusCode == 200
      ? jsonDecode(apiResponse.body)
      : {
          'type': false,
          'message': "Sistemsel bir hata meydana geldi.",
          'data': null
        };


}
