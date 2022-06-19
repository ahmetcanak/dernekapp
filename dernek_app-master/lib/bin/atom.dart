import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

// Önceki objenin üzerine değiştirerek döndürür
Map setState({state, newState}) =>
    [state, newState].reduce((map1, map2) => map1..addAll(map2));

// Ekran genişliği istenilen uzunlukta azaltarak ya da arttırarak döndürür
double screenWidth({context, increase: 0, decrease: 0}) =>
    MediaQuery.of(context).size.width + increase - decrease;

// Ekran genişliğini yüzdeliği döndürür
double screenWidthPercent({context, percent: 100}) =>
    MediaQuery.of(context).size.width * (percent / 100);

// Uygulamanın hafızasına eriş
Future<SharedPreferences> getStorage() async =>
    await SharedPreferences.getInstance();