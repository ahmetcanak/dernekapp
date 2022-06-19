import 'dart:convert';
import 'dart:io';
import 'package:dernek_app/bin/config.dart' as config;
import 'package:http/http.dart' as http;

Future<Map> message({token, subject, message, File image}) async {
  var apiResponse = http.MultipartRequest(
    'POST',
    Uri.parse('${config.apiUrl}/Message'),
  );
  apiResponse.files.add(await http.MultipartFile.fromPath('image', image.path));
  apiResponse.fields['type'] = "send";
  apiResponse.fields['subject'] = subject;
  apiResponse.fields['message'] = message;
  apiResponse.headers['Authorization'] = token;
  var res = await apiResponse.send();
  var response = await http.Response.fromStream(res);
  return response.statusCode == 200
      ? jsonDecode(response.body)
      : {
          'type': false,
          'message': "Sistemsel bir hata meydana geldi.",
          'data': null
        };
}
