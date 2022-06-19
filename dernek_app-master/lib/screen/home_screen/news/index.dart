import 'package:flutter/material.dart';
import 'package:dernek_app/component/loading.dart';
import 'package:dernek_app/api/index.dart' as Api;
import 'package:dernek_app/bin/theme.dart' as theme;
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:dernek_app/bloc/index.dart' as Bloc;
import 'package:shared_preferences/shared_preferences.dart';

class News extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _NewsState();
}

class _NewsState extends State {
  GlobalKey _scaffoldKey = GlobalKey<ScaffoldState>();

  ScrollController _scrollController = ScrollController();

  Bloc.UIBloc _uiBloc;
  Bloc.DeviceBloc _deviceBloc;

  SharedPreferences _storage;
  String _token;

  int _activeTagId = -1;

  bool _newsLoading = true;
  bool _newsFirstLoad = false;
  Map<int, String> _categories = {};
  List _news = [];
  int _newsTotal = 0;
  int _start = 0;
  int _length = 10;

  @override
  void initState() {
    super.initState();
    // UI
    _uiBloc = BlocProvider.of<Bloc.UIBloc>(context);
    _uiBloc.add(Bloc.SetScaffoldKey(scaffoldKey: _scaffoldKey));
    // Device
    _deviceBloc = BlocProvider.of<Bloc.DeviceBloc>(context);
    _storage = _deviceBloc.state['storage'];
    _token = _storage.getString('token');
    // Haberleri Al
    _getNews();
    // Scroll listener
    _scrollController.addListener(() {
      // Sayfanın en altına gelince anla
      if (_scrollController.position.atEdge &&
          _scrollController.position.pixels != 0) {
        // print('NewsTotal: ' + _newsTotal.toString());
        if (_start >= _newsTotal) return;
        _uiBloc.add(Bloc.AddSnackBar(type: 'warning', message: 'Haberler yükleniyor..'));
        setState(() {
          _start += _length;
        });
        _getNews();
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldKey,
      body: _newsLoading
          ? Loading()
          : Padding(
              padding: EdgeInsets.only(top: 0, left: 4, right: 4),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  _categoryList(),
                  Padding(
                    padding: EdgeInsets.only(
                        left: 10, right: 10, top: 10, bottom: 10),
                    child: Text(
                      "Haberler",
                      style: TextStyle(
                        fontWeight: FontWeight.w700,
                        fontSize: 28,
                      ),
                    ),
                  ),
                  Expanded(child: _newsList()),
                ],
              ),
            ),
    );
  }

  // Haberleri çek
  _getNews() {
    if (!_newsFirstLoad || _newsTotal > _start) {
      Api.news(token: _token, start: _start, length: _length)
          .then((newsResult) {
        // Haberlerden hata alınırsa
        if (!newsResult['type'])
          return _uiBloc.add(Bloc.AddSnackBar(
            type: 'error',
            message: newsResult['message'],
          ));
        setState(() {
          // Toplam haberler
          if (!_newsFirstLoad) _newsTotal = newsResult['data']['total'];
          // Haberleri Al
          _news = []..addAll(_news)..addAll(newsResult['data']['news']);
          // Kategorileri ayrıştır
          for (var category in newsResult['data']['categories'])
            _categories[category['id']] = category['category_name'];
          _newsLoading = false;
          _newsFirstLoad = true;
        });
        // Yükleme tamamlandı
        print("Haber listesi alındı");
      }).catchError(
        (err) => _uiBloc.add(Bloc.AddSnackBar(
          type: 'error',
          message: 'Uygulama içi bir hata meydana geldi',
        )),
      );
    }
  }

  // Haberlerin listesi
  Widget _newsList() {
    List news = [];
    // Seçilen kategoriye göre verileri al
    setState(() {
      _news.forEach((value) {
        if (_activeTagId != -1) {
          value['categories'].forEach((category) {
            if (_activeTagId == category['category_id']) news.add(value);
          });
        } else
          news.add(value);
      });
    });
    return ListView.builder(
      controller: _scrollController,
      itemCount: news.length,
      itemBuilder: (context, index) {
        return _cardBuilder(
          title: news[index]['title'],
          image: news[index]['thumbnail'],
          categories: news[index]['categories'],
          id: news[index]['id'],
        );
      },
    );
  }

  // Kategori Listesi
  Widget _categoryList() {
    List<Widget> categories = List<Widget>();
    categories.add(_tagBuilder(name: "Tümü", id: -1));
    _categories.forEach(
      (key, value) => categories.add(_tagBuilder(name: value, id: key)),
    );
    return Container(
      margin: EdgeInsets.only(top: 5, bottom: 0),
      height: 50.0,
      padding: EdgeInsets.all(0),
      child: ListView(
        scrollDirection: Axis.horizontal,
        children: categories,
      ),
    );
  }

  // Kart oluşturucu
  Widget _cardBuilder({image, title, categories, id}) => Padding(
        padding: EdgeInsets.only(left: 5, right: 5, top: 3, bottom: 3),
        child: Card(
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(20.0)),
          child: InkWell(
            splashColor: Colors.blue.withAlpha(30),
            onTap: () {
              _uiBloc.add(Bloc.NavigateTo(
                route: '/newDetail',
                arguments: {"id": id},
              ));
            },
            child: ClipRRect(
              borderRadius: BorderRadius.circular(20.0),
              child: Container(
                child: Stack(
                  children: <Widget>[
                    // Resim
                    Container(
                      child: Center(
                        child: Image.network(image, height: 200),
                      ),
                    ),
                    // Kategorileri
                    _cardTagBuilder(categories: categories),
                    // Çizgi
                    Container(
                      margin: EdgeInsets.only(top: 200),
                      child: Divider(height: 10, color: theme.color),
                    ),
                    // Alt başlık kısmı
                    Container(
                      margin: EdgeInsets.only(top: 210),
                      child: Padding(
                        padding: EdgeInsets.only(
                            left: 10, top: 10, bottom: 20, right: 10),
                        child: Text(
                          title,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 21,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      );

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
            backgroundColor: Colors.transparent,
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

  // TAG oluşturucu
  _tagBuilder({id, name}) => InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        child: Padding(
          padding: EdgeInsets.only(right: 3, left: 3),
          child: Chip(
            shadowColor: Colors.transparent,
            label: Text(
              name,
              style: TextStyle(
                color: theme.color,
                fontWeight: FontWeight.normal,
                // _activeTagId == id ? FontWeight.bold : FontWeight.normal,
              ),
            ),
            backgroundColor: _activeTagId == id
                ? theme.backgroundActiveColor
                : theme.backgroundColor,
          ),
        ),
        onTap: () {
          setState(() {
            _activeTagId = id;
          });
        },
      );
}
