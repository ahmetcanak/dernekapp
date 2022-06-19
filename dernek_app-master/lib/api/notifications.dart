import 'dart:convert';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:http/http.dart' as http;

Future<Map> notifications({token}) async {
  var _body = {'type': 'list'};
  var apiResponse = await http.post(
    '${config.apiUrl}/Notifications',
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
