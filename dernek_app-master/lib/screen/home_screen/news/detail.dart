import 'package:dernek_app/component/loading.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:dernek_app/api/index.dart' as Api;
import 'package:dernek_app/bin/atom.dart' as atom;
import 'package:shared_preferences/shared_preferences.dart';

class NewDetailScreen extends StatefulWidget {
  Map _arguments;
  NewDetailScreen({arguments}) : this._arguments = arguments;

  @override
  State<StatefulWidget> createState() =>
      _NewDetailScreenState(arguments: _arguments);
}

class _NewDetailScreenState extends State<NewDetailScreen> {
  int id;
  _NewDetailScreenState({arguments}) : this.id = arguments['id'];

  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  // Bloc
  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;

  SharedPreferences _storage;
  String _token;

  bool _newLoading = true;

  // Veriler
  String _currentTitle = "";
  String _currentImage = "";
  String _currentContent = "";
  String _currentTime = "";

  List _currentCategories = [];

  @override
  void initState() {
    super.initState();
    // UIBloc
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // DeviceBloc
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
    _token = _storage.getString('token');
    // Haberi Al
    Api.newDetail(token: _token, id: id).then((newDetailResult) {
      if (!newDetailResult['type'])
        return _uiBloc.add(Bloc.AddSnackBar(
          type: 'error',
          message: newDetailResult['message'],
        ));
      setState(() {
        _newLoading = false;
      });
      _currentTitle = newDetailResult['data']['title'];
      _currentImage = newDetailResult['data']['image'];
      _currentContent = newDetailResult['data']['content'];
      _currentTime = newDetailResult['data']['added_time'];
      _currentCategories = newDetailResult['data']['categories'];
      print(newDetailResult);
    }).catchError(
      (err) {
        print(err);
        _uiBloc.add(Bloc.AddSnackBar(
          type: 'error',
          message: 'Sistemsel bir hata meydana geldi.',
        ));
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      appBar: AppBar(
        centerTitle: false,
        title: Text(_newLoading ? "Yükleniyor.." : _currentTitle),
      ),
      body: _newLoading
          ? Loading()
          : SafeArea(
              child: SingleChildScrollView(
                child: Padding(
                  padding: EdgeInsets.only(
                    left: 5,
                    right: 5,
                    top: 10,
                    bottom: 3,
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      // Kategorileri
                      Padding(
                        padding: EdgeInsets.only(top: 8, right: 10, bottom: 15),
                        child: Align(
                          alignment: Alignment.topRight,
                          child: Row(
                            children: <Widget>[
                              Expanded(
                                child: _cardTagBuilder(
                                    categories: _currentCategories),
                              ),
                              // Tarih
                              Text(
                                _currentTime,
                                style: TextStyle(fontSize: 17),
                              ),
                            ],
                          ),
                        ),
                      ),
                      // Başlık
                      Padding(
                        padding: EdgeInsets.only(
                          top: 10,
                          left: 15,
                          right: 5,
                          bottom: 20,
                        ),
                        child: Text(
                          _currentTitle,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 23,
                          ),
                        ),
                      ),
                      // Resim
                      Card(
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20.0),
                        ),
                        child: Container(
                          child: Center(
                            child: Image.network(
                              _currentImage,
                              width: atom.screenWidth(context: context),
                            ),
                          ),
                        ),
                      ),
                      // Açıklama
                      Padding(
                        padding: EdgeInsets.only(
                            left: 10, top: 25, right: 10, bottom: 15),
                        child: Text(
                          _currentContent,
                          style: TextStyle(fontSize: 18),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
    );
  }

  // Kartlar içindeki tagler
  _cardTagBuilder({categories}) {
    List tags = List<Widget>();
    // for (int i = 0; i <= 10; i++)
    categories.forEach(
      (category) => tags.add(
        Container(
          constraints: BoxConstraints(maxHeight: 10),
          child: Chip(
            shadowColor: Colors.transparent,
            backgroundColor: theme.backgroundActiveColor,
            label: Text(
              category['category_name'],
              overflow: TextOverflow.ellipsis,
              style: TextStyle(
                fontWeight: FontWeight.normal,
                color: theme.color,
              ),
            ),
          ),
        ),
      ),
    );
    return Container(
      margin: EdgeInsets.only(top: 5, bottom: 0, left: 5, right: 5),
      height: 30.0,
      // padding: EdgeInsets.only(top),
      child: ListView(
        scrollDirection: Axis.horizontal,
        children: tags,
      ),
    );
    // ListView.builder(
    //   // shrinkWrap: true,
    //   itemCount: tags.length,
    //   itemBuilder: (context, index) => tags[index],
    // );
  }
}
