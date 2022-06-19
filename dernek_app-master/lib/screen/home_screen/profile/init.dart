import 'package:dernek_app/screen/home_screen/profile/profile_child.dart';
import 'package:flutter/material.dart';

List<DropdownMenuItem<String>> getDropDownMenuItems(List list) {
  List<DropdownMenuItem<String>> items = List();
  items = [];
  for (String item in list) {
    items.add(new DropdownMenuItem(
        value: item,
        child: Container(
            child: new Text(
          item,
        ))));
  }
  return items;
}

List _tahsiliList = [
  "İlkokul",
  "Ortaokul",
  "Lise",
  "Önlisans",
  "Lisans",
  "YüksekLisans",
  "Doktora"
];
List _kanList = ["0-", "0+", "A-", "A+", "B-", "B+", "AB-", "AB+"];

List<DropdownMenuItem<String>> dropDownMenuItems =
    getDropDownMenuItems(_tahsiliList);
List<DropdownMenuItem<String>> dropDownMenuItems2 =
    getDropDownMenuItems(_kanList);

Future showModal(
    {BuildContext context, List children, int editIndex: -1}) async {
  await showModalBottomSheet(
      isScrollControlled: true,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.only(
            topLeft: Radius.circular(20), topRight: Radius.circular(20)),
      ),
      context: context,
      builder: (context) {
        return ProfileChild(children: children, editIndex: editIndex);
      });
}

String dateToGGMMYY(date) {
  Map newDate = {
    'day': date.day.toString().length == 1
        ? '0' + date.day.toString()
        : date.day.toString(),
    'month': date.month.toString().length == 1
        ? '0' + date.month.toString()
        : date.month.toString(),
    'year': date.year.toString(),
  };
  return newDate['day'] + '/' + newDate['month'] + '/' + newDate['year'];
}

phoneMaskToPhone(String maskPhone) {
  maskPhone =
      maskPhone.replaceAll('(', '').replaceAll(')', '').replaceAll(' ', '');
  return maskPhone.indexOf('+90') > -1 ? maskPhone.split('+90')[1] : maskPhone;
}
