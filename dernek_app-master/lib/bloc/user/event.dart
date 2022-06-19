abstract class UserEvent {}

class SetUser extends UserEvent {
  final children;
  final name;
  final surname;
  final tc;
  final birth;
  final study;
  final job;
  final bloodGroup;
  final phone;
  final fatherName;
  final motherName;
  final motherFatherName;
  final nickName;
  final villageNeighborhood;
  final homeAddress;
  final homePhone;
  final email;
  final businessAddress;
  final businessPhone;
  final wifeName;
  final wifeBloodGroup;
  final wifeFatherName;
  SetUser({
    this.children,
    this.name,
    this.surname,
    this.tc,
    this.birth,
    this.study,
    this.job,
    this.bloodGroup,
    this.phone,
    this.fatherName,
    this.motherName,
    this.motherFatherName,
    this.nickName,
    this.villageNeighborhood,
    this.homeAddress,
    this.homePhone,
    this.email,
    this.businessAddress,
    this.businessPhone,
    this.wifeName,
    this.wifeBloodGroup,
    this.wifeFatherName,
  });
}
