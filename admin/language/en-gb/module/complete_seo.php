<?php
// Русский перевод модуля от Alexius http://alexius.esy.es/
// Заголовок
$_['heading_title']		  				= '<img src="view/seo_package/img/icon.png" style="vertical-align:top;padding-right:4px"/><span style="color:#11b209">Complete SEO</span> <span style="color:#555">Package</span>';
$_['module_title']		  				= 'Complete SEO <span>Package</span>';
  
  
$_['text_store_select'] = 'Магазин';

// Dashboard
$_['tab_seo_dashboard'] = 'Панель состояния';
$_['text_seo_score'] = 'SEO Мощность';
$_['text_dashboard_config'] = 'SEO Обзор'; 
 
// Таб seo эдитор
$_['tab_seo_editor']      				= 'SEO Редактор';
$_['tab_seo_editor_product']			= 'Товар';
$_['tab_seo_editor_category']			= 'Категория';
$_['tab_seo_editor_information']		= 'Информация';
$_['tab_seo_editor_manufacturer']		= 'Производитель';
$_['tab_seo_editor_image']				= 'Картинка';
$_['tab_seo_editor_absolute']			= 'Абсолютная ссылка';
$_['tab_seo_editor_common']				= 'Простая страница';
$_['tab_seo_editor_special']			= 'Специальные страницы';
$_['tab_seo_editor_redirect']			= 'Url переадресация';
$_['tab_seo_editor_404']				= 'Менеджер 404';
$_['text_multistore']					= 'Мультимагазинное SEO';
$_['info_multistore']					= 'Предоставляйте различные сведения о SEO (ключевое слово, мета и т. Д.) По продуктам и категориям для каждого магазина';
$_['text_editor_count']					= 'Счетчик';
$_['text_editor_query']					= 'Запрос';
$_['text_editor_query_redirect'] 		= 'Запрос';
$_['text_editor_query_absolute']		= 'Полный запрос (значение после route=)';
$_['text_editor_query_common']			= 'Запрос (значение после route=)';
$_['text_editor_query_special']			= 'Запрос (прим: custom_id=1)';
$_['text_editor_image']					= 'Какртинка';
$_['text_editor_name']					= 'Имя';
$_['text_editor_title']					= 'Тайтл';
$_['text_editor_meta_title']			= 'Мета Тайтл';
$_['text_editor_meta_keyword']			= 'Мета кейворд';
$_['text_editor_meta_description']		= 'Мета описание';
$_['text_editor_url']					= 'ЧПУ';
$_['text_editor_url_absolute']			= 'Полная СЕО ссылка';
$_['text_editor_url_redirect']			= 'Переадресация в';
$_['text_editor_tag']					= 'Теги';
$_['text_editor_h1']					= 'СЕО H1';
$_['text_editor_item_name']				= 'Название товара';
$_['text_editor_image_name']			= 'Название';
$_['text_editor_image_alt']				= 'Альт';
$_['text_editor_image_title']			= 'Тайтл';
$_['text_editor_related']				= 'Рекомендуемое';
$_['text_seo_new_alias_title']			= 'Новая ссылка';
$_['text_seo_new_absolute_alias_info'] 	= 'Переписать все ссылки на абсолютный путь, например index.php?route=<b>blog/blog&post_id=123</b><br/>В поле запроса вставьте <b>blog/blog&post_id=123</b> (вставляйте только значение после index.php?route=)<br/>В поле СЕО ссылки вставляйте только значение, котрое вы хотите: <b>blog/this-is-a-blog-post</b>';
$_['text_seo_new_alias_info']			= 'Переписать ссылку использующие параметр маршрута (rout), например index.php?route=<b>account/account</b><br/>В запросе вставьте <b>account/account</b> 
(нет необходимости вставлять route=)<br/>В поле ЧПУ вставьте нужное значение: <b>my-account</b>';
$_['text_seo_new_spec_alias_info']	= 'Переписывайте URL-адреса, относящиеся к любому настраиваемому модулю, даже если он не предназначен для обработки дружественных URL-адресов.<br/>Например index.php?<b>blog_news_id=123</b>
<br/>В поле запроса пишите <b>blog_news_id=123</b><br/>В поле ЧПУ нужный параметр: <b>a-great-url-for-my-great-news</b>';
$_['text_seo_new_redirect']	= 'Это генерирует 301 переадресацию, чтобы указать поисковым машинам, что текущий URL-адрес был перенесен на новый. Используйте эту функцию, чтобы исправить ошибки сканирования с веб-мастера google.<br/>
<br/>В поле запроса полная ссылка: <b>http://example.com/broken-url</b><br/>В поле переадресации новая ссылка: <b>http://example.com/fixed-url</b><br/><br/>Или без имени домена (не зубудьте в начале слеш: /)<br/>
В запросе: <b>/broken-url</b><br/>В переадресации: <b>/fixed-url</b><br/><br/>Динамическое перенаправление<br/>Если вы хотите, чтобы он работал даже с дополнительными обновлениями URL-адресов, заполните поле перенаправления таким образом:<br/>
<b>product/product&product_id=42</b> (где 42 это актуальный айди товара)';
$_['text_info_limits_tab'] = 'Пределы метаданных';
$_['text_info_limits_title'] = 'Пределы тайтлов и описания';
$_['text_info_robots'] = '<h4>Мета-роботы</h4>
<p>Метатег роботов позволяет использовать гранулированный, зависящий от страницы подход к управлению тем, как индивидуальная страница должна индексироваться и обслуживаться пользователям в результатах поиска.<br/>
Установленный здесь параметр будет по умолчанию для всех страниц вашего магазина, тогда вы можете отредактировать конкретный продукт, чтобы изменить значение робота (на вкладке данных) только для этого продукта.<br/>
Параметр meta robots будет установлен на вашей странице как метатег в разделе главы: &lt;meta name="robots" /&gt;</p>
<table class="table table-bordered">
  <tbody><tr><th>Значение</th><th>Директивы</th></tr>
  <tr><td><code><span>all</span></code></td>
    <td>Нет никаких ограничений на индексацию или обслуживание. Примечание: эта директива является значением по умолчанию и не имеет никакого эффекта, если явно указано, поэтому, когда вы выберете это значение, 
	метка мета-роботов не будет отображаться</td></tr>
  <tr><td><code><span>noindex</span></code></td>
    <td>Не показывать эту сраницу в поиске</td></tr>
  <tr><td><code><span>nofollow</span></code></td>
    <td>Не переходить по ссылкам на этой странице</td></tr>
  <tr><td><code><span>none</span></code></td>
    <td>Эквивалент <code><span>noindex,<wbr> nofollow</span></code></td></tr>
  <tr><td><code><span>noimageindex</span></code></td>
    <td>Не индексировать картинки на этой старнице.</td></tr>
</tbody></table>
<h4>Автоматические настройки</h4>
<p>После включения вы сможете определить значение по умолчанию для мета-роботов, и модуль автоматически применит лучший параметр для некоторых конкретных страниц, см. Следующий список, чтобы узнать, какие параметры автоматически устанавливаются на вашем веб-сайте:</p>
<table class="table table-bordered">
<tr><th style="width:220px">Тип</th><th>Значения мета роботс</th></tr>
<tr><td>Пагинация pages</td><td><code>noindex, follow</code></td></tr>
<tr><td>Страницы с ограниченными параметрами</td><td><code>noindex, follow</code></td></tr>
<tr><td>Страница поиска</td><td><code>none</code> (noindex, nofollow)</td></tr>
</table>
';
$_['text_info_limits'] = '<h4>Лимиты мета тайтлов и описания</h4>
<p>Мета-заголовок и описание очень важны, так как они видят, что пользователь увидит при запросе на поисковые системы, заголовок в качестве основной ссылки и описание небольшого текста ниже..</p>
<p><img src="view/seo_package/img/help/meta_title_desc.png" alt="" class="img-thumbnail"/></p>
<p>Google урезает ваш заголовок после 67 символов, но будет индексировать еще несколько, чтобы это было легко визуализировать, поле заголовка станет оранжевым в случае обхода 67 символов и красного цвета в случае обхода 85 символов.<br/>
Пределы для описания - 155 символов для урезания и 200 для индексации.</p>
<p><span style="color:#fc7402">Оранжевый</span> означает, что ваш текст обязательно будет усечен, но будет полностью проиндексирован.<br />
<span style="color:#f23333">Красный</span> Означает, что некоторые слова в конце вашего текста не индексируются.</p>';
$_['entry_analytics_code'] = 'Код Google Аналитики:';
$_['text_info_analytics_tab'] = 'Google Аналитика';
$_['text_info_analytics'] = '<h4>Проверьте свой сайт в Google Analytics</h4>
<p>Вы можете получить подробную информацию о своем веб-сайте с помощью Google Analytics, для этого перейдите по ссылке <a href="https://www.google.com/webmasters/">https://www.google.com/webmasters/</a> 
И нажмите «ДОБАВИТЬ СОБСТВЕННОСТЬ», затем выберите способ проверки HTML-тегов, например, на изображении ниже.</p>
<p><img src="view/seo_package/img/help/gg_analytics.png" alt="" class="img-thumbnail"/></p>
<p>Скопируйте код, указанный Google, чтобы активировать проверку вашего веб-сайта. Теперь вы можете проверить страницу google.</p>';

// Таб seo конфигурации
$_['tab_seo_options']      		= 'SEO Конфигурация';
$_['text_seo_package_status']	= 'SEO Package статус:';
$_['text_seo_components']		= 'Компоненты:';
$_['text_seo_tab_general_1']	= 'Главные опции';
$_['text_seo_tab_general_2']	= 'Теги языка';
$_['text_seo_tab_general_3']	= 'Hreflang';
$_['text_seo_tab_general_4']	= 'Опции кейвордов';
$_['text_seo_tab_general_5']	= 'Автообновление';
$_['text_seo_tab_general_6']	= 'Пагинация';
$_['text_seo_tab_general_7']	= 'Кеш';
$_['text_seo_tab_general_8']	= 'Канонические ссылки';
$_['text_seo_tab_general_9']	= '';
$_['text_seo_tab_general_10']	= 'Отзывы';
$_['text_seo_tab_general_11']	= 'Запросить заголовки';
$_['text_seo_tab_general_12']	= 'Карта сайта';
$_['text_seo_tab_general_13']	= 'Мета роботс';
$_['text_seo_tab_general_14']	= 'Переадресация';
$_['text_seo_tab_general_16']	= 'Модули СЕО';
$_['text_info_general']			= 'Эти настройки влияют на глобальное функционирование оптимизаторов, они вступают в силу немедленно и могут быть изменены в любое время.';
$_['text_info_general_3']		= 'Тег Hreflang позволяет поисковым системам знать URL текущей страницы для других языков.<br/>
После активации он будет включен во все страницы вашего сайта, а также в карту сайта seo (feed> seo package карта сайта).<br/> 
Подробнее : <a href="https://support.google.com/webmasters/answer/189077?hl=en" target="new">здесь</a>';
$_['text_info_general_6']		= 'Перезапись пагинации на дружественную, например website.com/category?page=3 станет website.com/category/page-3';
$_['text_info_general_7']		= 'Функция кеша ускорит ваш сайт, кэшируя все URL-ссылки, а не вычисляя их каждый раз';
$_['text_info_general_8']		= 'Канонические ссылки информируют поисковые системы, что если он найдет одну и ту же страницу в другом месте на веб-сайте, она должна рассматривать только одну ссылку, это важно для того, чтобы избежать дублирования контента';
$_['text_info_general_10']		= 'В обзорах opensart по умолчанию загружаются динамически с помощью ajax, что заставляет поисковые системы не видеть контент отзывов, который был бы ценным контентом для вашего веб-сайта, включите этот параметр, чтобы он мог вставить блок, содержащий отзывы пользователей в HTML, чтобы сделать Чтобы их можно было увидеть.<br />
<br />Вы должны вручную вставить этот код в product/product.tpl шаблон : <b>&lt;?php echo $seo_reviews; ?&gt;</b><br />
<br /> Затем вы можете стилизовать его так, как хотите, контейнерный класс <b>.seo_reviews</b>, класс позиции <b>.seo_review</b>';
$_['text_info_general_12']		= 'Карта сайта должна быть настроена в разделе фидов, пожалуйста, нажмите на кнопку ниже, чтобы настроить ее.';
$_['text_seopackage_sitemap']	= 'SEO Package Карта сайта';
$_['text_seo_pagination']		= 'Включить СЕО пагинацию<span class="help">Предупреждение: это несовместимо с ajax пагинацией, включающей некоторые темы, если это не работает, вам придется отключить разбиение на страницы или ajax разбиение на страницы темы</span>';
$_['text_seo_pagination_fix']   = 'Предыдущий/следующий фикс:<span class="help">Фикс opencart 2.2+ проблемы с предыдущий/следующий в подкатегориях</span>';
$_['text_seo_pagination_canonical'] = 'Канонические с разбивкой на страницы:<span class="help">Установите каноническую ссылку страниц страницы, чтобы указать номер страницы (не рекомендуется)</span>';
$_['text_seo_canonical']		= 'Канонические:<span class="help">Включить каноникал для всех страниц</span>';
$_['text_seo_absolute']			= 'Абсолютная категория:<span class="help">Разрешить использовать одно и то же ключевое слово для подкатегорий и что-то еще (прим: <br/>/laptop/apple<br/>/desktop/apple<br/>/apple (производитель))<br/>Если вы укажете ключевое слово для производителя, его нельзя использовать для верхней категории (/apple and /apple), только подкатегория</span>';
$_['text_seo_absolute_help']	= 'Позвольте использовать одно и то же ключевое слово для подкатегорий и что-то еще (например: <br/> / laptop / apple <br/> / desktop / apple <br/> / apple (производитель)) <br/> Если вы укажете ключевое слово для Производитель, он не может использоваться для верхней категории (/apple и /apple), только подкатегории';
$_['text_seo_reviews']			= 'SEO отзывы:<span class="help">Вставить отзывы в HTML-контент</span>';
$_['text_seo_extension']		= 'Пример:<span class="help">Добавьте расширение по вашему выбору в конце ключевого слова продукта (прим: .html)</span>';
$_['text_seo_flag_tag']			= 'Тег после домена';
$_['text_seo_flag_store']		= 'Тег как поддомен';
$_['text_seo_flag']				= 'Режим языковых тегов:';
$_['text_seo_flag_short']		= 'Короткий тег:';
$_['text_seo_flag_upper']		= 'Тег в верхнем регистре:';
$_['text_seo_flag_default']		= 'Без тегов по умолчанию:';
$_['text_seo_urlcache']			= 'URL Кеш:<span class="help">Ускорить загрузку страницы с помощью кэширования URL-адресов</span>';
$_['text_seo_redirect_dynamic']			= 'Переадресация динамических ссылок:<span class="help">Динамические ссылки (route=product/product&product_id=32) будут автоматически перенаправлены на их дружественные URL-адреса, если они существуют. Перенаправление - 301, поэтому поисковая система остановится, чтобы индексировать его и использовать только дружественный URL-адрес в качестве ссылки.</span>';
$_['text_seo_redirect_canonical']		= 'Переадресация на каноникал:<span class="help">Это для дружественных URL-адресов, он проверяет, является ли текущая ссылка канонической ссылкой, если она не будет перенаправлена на каноническую. Это позволяет не использовать несколько URL-адресов для одного элемента. Перенаправление - 301.</span>';
$_['text_seo_redirect_canonical_1']		= 'Перенаправить все ссылки, кроме ссылок категории';
$_['text_seo_redirect_canonical_2']		= 'Redirect all links including category links';
$_['text_seo_redirect_http']	      	= 'HTTP режим:<span class="help">Используйте это, чтобы заставить веб-сайт использовать SSL или www, если URL неверен, будет выполнено 301 переадресация.</span>';
$_['text_seo_redirect_ssl']	      	    = 'Режим SSL значения, не изменяя WWW';
$_['text_seo_redirect_www']	      	    = 'Режим WWW значения, не изменяя SSL';
$_['text_seo_redirect_sslwww']	      	= 'Режим обоих SSL и WWW значений';
$_['text_seo_redirect_http_1']	      	= 'Без-SSL, Без-WWW - http://example.com';
$_['text_seo_redirect_http_2']	      	= 'Без-SSL, WWW - http://www.example.com';
$_['text_seo_redirect_http_3']	      	= 'SSL, Без-WWW - https://example.com';
$_['text_seo_redirect_http_4']	      	= 'SSL, WWW - https://www.example.com';
$_['text_seo_redirect_http_5']	      	= 'SSL - https://(www.)example.com';
$_['text_seo_redirect_http_6']	      	= 'Без-SSL - http://(www.)example.com';
$_['text_seo_redirect_http_7']	      	= 'WWW - http(s)://www.example.com';
$_['text_seo_redirect_http_8']	      	= 'Без-WWW - http(s)://example.com';
$_['text_seo_special_group']			= 'Специальная ценовая группа:<span class="help">[price] тег может рассчитать специальную цену, определите здесь, какую группу клиентов вы хотите использовать для ее расчета, если отключено, тогда будет отображаться только цена по умолчанию</span>';
$_['text_seo_format_tag']		= 'Форматирование тегов:<span class="help">Добавление запятых между каждым словом к тегам продукта при генерации при массовом обновлении или автоматическом обновлении</span>';
$_['text_seo_banner']					= 'Перезапись ссылок банеров:<span class="help">Динамически создавать seo-ссылку на баннеры (используется в баннерах, каруселях, модулях слайд-шоу)</span>';
$_['text_seo_banner_help']				= 'В разделе баннеров не вводите ссылку seo(/category/product_name) но вместо этого введите ссылку по умолчанию opencart: <b>index.php?route=product/product&path=10_21&product_id=54</b>.<br />
Вы также можете index.php, like this : <b>product/product&path=23&product_id=48</b>';
$_['text_seo_hreflang']					= 'Включить тег hreflang:';
$_['text_seo_substore']					= 'Включить многозадачную перезапись:';
$_['text_seo_substore_config'] 			= 'Актуальная конфигурация:';
$_['text_no_language_defined'] 			= 'Язык не определен';
$_['text_info_transform']				= 'Все эти параметры определяют способ генерации ключевого слова при сохранении элемента или использовании массового обновления.';
$_['text_seo_whitespace']				= 'Пробелы:<span class="help">Замените символы пробела ...</span>';
$_['text_seo_lowercase']				= 'Строчные:<span class="help">QWERTY => qwerty</span>';
$_['text_seo_remove']					= 'Удалить слова:<span class="help">Удалите некоторые слова при создании URL-адресов, их можно использовать для удаления общих слов типа «о, a, ...», поместить запятую между каждой</span>';
$_['text_seo_duplicate']				= 'Дубли:<span class="help">Разрешить использовать одно и то же ключевое слово для отдельной языковой версии элемента</span>';
$_['text_seo_ascii']					= 'ASCII режим:<span class="help">Замените акцентированные символы их эквивалентом ascii<br/>"éàôï" => "eaoi"<br/>Поддерживаемые языки: All latin (French, Italian, Spanish, etc), Arabic, Bulgarian, Croatian, Czech, German, Greek, Latvian, Lithunanian, Polish, Romanian, Русский, Serbian, Slovenian, Turkish, Украинский</span>';
$_['text_seo_autofill']					= 'Автозаполнение';
$_['text_seo_autofill_on']				= 'вкл:';
$_['text_seo_autofill_desc']			= 'Автозаполнение:<span class="help">Если оставить поле пустым при вставке или редактировании, значение будет создано автоматически на основе шаблона на вкладке массового обновления.<br/>
<br/>Работает с : <br/>- товар<br/>- категории<br/>- инфомация</span>';
$_['text_seo_autourl']					= 'Авто URL:<span class="help">Если оставить пустым, ключевое слово seo url будет сгенерировано автоматически, используя параметр, установленный на вкладке «Массовое обновление»<br/>
Работает с товаром, категориями и информацией</span>';
$_['text_seo_autotitle']				= 'Автоматическое название и описание для других языков:<span class="help">Если они оставлены пустыми при вставке или редактировании, названия и описания других языков будут копировать заголовок и описание языка по умолчанию<br/>
Работает с товаром, категориями и информацией</span>';
$_['text_headers_lastmod'] 				= 'Последнее редактирование:<span class="help">Добавить последнюю измененную дату в шапку</span>';
$_['text_all']							= 'Все';
$_['text_insert']						= 'Вставить';
$_['text_edit']							= 'Редактировать';

$_['text_fix_search']   				= 'Фикс поисковых ссылок:';
$_['text_fix_search_help']   			= '<span class="help">Поисковые урлы могут быть некрасивые, потому что URL-адрес жестко закодирован в javascript, включите эту опцию, если вы хотите, чтобы URL-адрес поиска был заменен.</span>';
$_['text_fix_cart']   					= 'Исправить ошибку удаления корзины:';
$_['text_fix_cart_help']   				= '<span class="help">Когда есть дружественный url для checkout/cart, удаление продукта не обновляет текущий экран, включите это, чтобы исправить эту проблему.</span>';

// Таб магазинного seo
$_['tab_seo_store']      				= 'Магазинное SEO';
$_['text_info_store']					= '<h4>Магазинное SEO</h4>
<p>В этом разделе вы можете настроить мета-заголовок, h1, мета ключевые слова и описание на домашней странице для каждого магазина и на каждом языке! <br/> Все, что вводится здесь, будет обходить значения, введенные в настройках opencart.</p>
<p>Значения заголовков могут не применяться автоматически в зависимости от темы, чтобы вставить их, вы должны отредактировать свой обычный / домашний шаблон (и то же самое в шаблонах прод / кат / инфо) и использовать эти коды: <br/><code style="padding:0">&lt;h1&gt;&lt;?php echo $seo_h1; ?&gt;&lt;/h1&gt;<br/>&lt;h2&gt;&lt;?php echo $seo_h2; ?&gt;&lt;/h2&gt;<br/>&lt;h3&gt;&lt;?php echo $seo_h3; ?&gt;&lt;/h3&gt;</code></p>
<p>Учтите, что элементы с дисплеем: ни один из них не может быть рассмотрен поисковыми системами, поэтому вы можете захотеть вставить только некоторые из них в зависимости от вашего шаблона (h1 является самым важным).</p>
<h4>Префикс и суффикс заголовка Мета</h4>
<p>Используйте этот параметр, чтобы добавить текст до или после всех названий вашего сайта, они могут быть определены для каждого магазина и каждого языка.</p>
<p>Например, если вы хотите, чтобы ваш заголовок <b>"Название товара | Мой магазин"</b> просто вставьте <b>" | Мой магазин"</b> в суффикс.</p>';
$_['text_info_seo_titles_tab']				= 'SEO Тайтлы (H1, H2, H3)';
$_['text_info_seo_titles']				= '<h4>SEO тайтлы (H1, H2, H3)</h4>
<p>Заголовки SEO не применяются автоматически к вашей теме, потому что это изменит ваш дизайн, поэтому вам придется вручную вставлять их в свои шаблоны.<br/><br/>Файлы для изменения
(.tpl or .twig):<br/><code style="padding:0">/catalog/view/theme/[theme]/template/common/home<br/>/catalog/view/theme/[theme]/template/product/product<br/>/catalog/view/theme/[theme]/template/product/category<br/>
/catalog/view/theme/[theme]/template/product/information</code><br/><br/>
Вставьте этот код для .tpl: <br/><code style="padding:0">&lt;h1&gt;&lt;?php echo $seo_h1; ?&gt;&lt;/h1&gt;<br/>&lt;h2&gt;&lt;?php echo $seo_h2; ?&gt;&lt;/h2&gt;<br/>&lt;h3&gt;&lt;?php echo $seo_h3; ?&gt;&lt;/h3&gt;</code><br/><br/>
Или этот для .twig: <br/><code style="padding:0">&lt;h1&gt;{{ seo_h1 }}&lt;/h1&gt;<br/>&lt;h2&gt;{{ seo_h2 }}&lt;/h2&gt;<br/>&lt;h3&gt;{{ seo_h3 }}&lt;/h3&gt;</code><br/></p>
<p>Учтите, что элементы с отображением: ни один из них не может быть рассмотрен поисковыми системами, поэтому вы можете захотеть вставить только некоторые из них в зависимости от вашего шаблона (h1 является самым важным).</p>';

$_['entry_robots']     					= 'Включить мета роботс';
$_['store_seo_global'] 					= 'Глобальные настройки';
$_['store_seo_home'] 					= 'Только главная страница';
$_['entry_robots_default']      		= 'Значение по умолчанию';
$_['entry_store_seo_title']     	 	= 'Мета тайтл:';
$_['entry_store_seo_title_extra'] 		= 'Мета тайтл префикс и суффикс:';
$_['entry_store_title']      			= 'Тайтл H1:';
$_['entry_store_h2']      	  			= 'Тайтл H2:';
$_['entry_store_h3']      	  			= 'Тайтл H3:';
$_['entry_store_desc']      			= 'Мета описание:';
$_['entry_store_keywords']				= 'Мета кейворды:';

// Таб расширенных описаний
$_['tab_seo_snippets']				= 'Расширенные описания';
$_['text_seo_tab_snippet_1']		= 'Google Микроданные (Rich Cards)';
$_['text_seo_tab_snippet_2']		= 'Facebook Open Graph';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_4']		= 'Google Publisher';
$_['tab_microdata_1']		        = 'Товар';
$_['tab_microdata_2']		        = 'Организация';
$_['tab_microdata_3']		        = 'Магазин';
$_['tab_microdata_4']		        = 'Вебсайт';
$_['tab_microdata_5']		        = 'Место';
$_['tab_microdata_6']		        = 'Хлебные крошки';
$_['entry_snippet_pricerange']		= 'Ценовой диапозон:';
$_['entry_snippet_same_as']		  	= 'Такой как:';
$_['entry_enable_microdata']		= 'Включить Google Microdata:';
$_['entry_microdata_search']		= 'Поисковая строка';
$_['entry_microdata_logo']		  	= 'Лого';
$_['entry_microdata_address']	  	= 'Адрес';
$_['entry_snippet_contact']			= 'Контакты';
$_['entry_microdata_gps']		    = 'GPS координаты';
$_['entry_gps_lat']		          	= 'Широта';
$_['entry_gps_long']		        = 'Долгота';
$_['entry_address_street']     		= 'Улица';
$_['entry_address_city']        	= 'Местонахождение';
$_['entry_address_region']      	= 'Регион';
$_['entry_address_code']       	 	= 'Почтовый код';
$_['entry_address_country']     	= 'Страна';
$_['entry_email']		            = 'Email';
$_['entry_phone']		            = 'Телефон';
$_['entry_product_data']		    = 'Включить данные о продукте:';
$_['entry_snippet_data']		    = 'Включить данные:';
$_['entry_model']		            = 'Модель';
$_['entry_description']		      	= 'Описание (основано на метадескрипшине)';
$_['entry_reviews']		          	= 'Отзывы';
$_['entry_upc']		              	= 'UPC';
$_['entry_mpn']		              	= 'MPN';
$_['entry_ean']		              	= 'EAN';
$_['entry_isbn']		            = 'ISBN';
$_['entry_rating']		          	= 'Средний рейтинг';
$_['entry_manufacturer']		    = 'Производитель';
$_['entry_brand']		            = 'Бренд';
$_['entry_enable_opengraph']		= 'Включить Facebook Open Graph:';
$_['entry_opengraph_id']		    = 'Facebook App ID:';
$_['entry_enable_tcard']		    = 'Включить Twitter Card:';
$_['entry_twitter_nick']		    = 'Twitter никнейм (опционально):';
$_['entry_twitter_home_type']		= 'Тип главной:';
$_['entry_twitter_summary']		  	= 'Сводка';
$_['entry_twitter_summary_large'] 	= 'Сводка с большим изображением';
$_['entry_enable_gpublisher']		= 'Включить Google Publisher:';
$_['entry_gpublisher_url']		    = 'Google+ url:';


// Таб дружественных УРЛ
$_['tab_seo_friendly']				= 'Дружественные URLs';
$_['text_seo_export_urls']			= 'Экспорт URLs';
$_['text_seo_export_urls_tooltip'] 	= 'Экспорт дружественных URL-адресов и отправка их разработчику для интеграции в официальный пакет';
$_['text_seo_reset_urls']  			= 'Восстановить дефолтные URLs';
$_['text_seo_reset_urls_tooltip']	= 'Если текущий язык не имеет предопределенных URL-адресов, модуль загрузит английскую версию';
$_['text_info_friendly']			= 'Здесь вы можете управлять дружественными URL-адресами, редактировать их по своему усмотрению.<br/>
У вас также есть возможность добавить новый URL-адрес, он работает, например, для любого настраиваемого модуля, который вы установили, просто заполните 1-е поле значением в маршруте (?route=mymodule/action) и вторым полем с ключевым словом, которое вы хотите отобразить В URL.';
$_['text_seo_friendly']				= 'Дружественные URL-адреса для общих страниц:<span class="help">Включите эту опцию, чтобы использовать дружественные URL-адреса для общих страниц и специальных страниц (отредактируйте их на вкладке редактора SEO)</span>';
$_['info_seo_friendly']				= 'Включите этот компонент, чтобы переписать URL-адреса для общих URL-адресов страниц и параметров';
$_['info_seo_absolute']				= 'Включите этот компонент, чтобы использовать абсолютные URL-адреса';
$_['info_seo_404']			    	= 'Включите этот компонент, чтобы активировать протоколирование 404 страниц ошибок';
$_['info_seo_redirect']				= 'Включить этот компонент для активации 301 перенаправления';
$_['text_seo_cat_slash']			= 'Слеш в конце в категорий';
$_['text_seo_cat_slash_help']		= 'Вставить окончательный слеш в конце URL-адресов категорий';
$_['text_seo_redir_reviews'] 		= 'Перенаправление битых отзывов:<span class="help">Если на странице обзора index.php?route=product/product/review не открывается через ajax-запрос, то перенаправление 301 на страницу продукта. Это предотвратит индексирование этого фрагмента обзора.</span>';
$_['text_seo_remove_urls'] 			= 'Удалить все записи';
$_['text_seo_remove_redirected'] 	= 'Удалить перенаправленные записи';
$_['text_seo_add_url']      		= 'Добавить новую запись';

// Таб полного пути товараh
$_['tab_seo_fpp']					= 'Менеджер путей';
// Текст
$_['tab_fpp_product']   			= 'Товар';
$_['tab_fpp_category']   			= 'Категория';
$_['tab_fpp_manufacturer']   		= 'Производитель';
$_['tab_fpp_search']   				= 'Поиск';
$_['tab_fpp_common']   				= 'Общее';
$_['text_fpp_cat_canonical']   		= 'Каноникал категории:';
$_['text_fpp_cat_mode_0']   		= 'Прямая ссылка';
$_['text_fpp_cat_mode_1']   		= 'Полный путь';
$_['text_fpp_cat_canonical_help']   = 'Какую ссылку вы хотите показать поисковым системам? <br/><b>Прямая ссылка</b>: /category (default)<br/><b>Полный путь</b>: /cat1/cat2/category<br/>
<br/>В режиме прямой ссылки связи каноникал автоматически устанавливается также по прямой ссылке';
$_['text_fpp_mode']   				= 'Режим пути товара:';
$_['text_fpp_mode_0']  		 		= 'Прямая ссылка';
$_['text_fpp_mode_1']   			= 'Короткий путь';
$_['text_fpp_mode_2']   			= 'Длинный путь';
$_['text_fpp_mode_3']   			= 'С производителем';
$_['text_fpp_mode_4']   			= 'Последняя категория';

$_['text_fpp_slash']   				= 'Слеш в конце';
$_['text_fpp_slash_mode_0']   		= 'Без Слеша в конце';
$_['text_fpp_slash_mode_1']   		= 'Слеш в конце категорий';
$_['text_fpp_slash_mode_2']   		= 'Слеш в конце на всех ссылках';
$_['text_fpp_slash_help']   		= 'Добавляет слеш в конце. Ника не влияет на СЕО';

$_['text_fpp_bc_mode'] 				= 'Режим хлебных крошек:';
$_['text_fpp_breadcrumbs_fix'] 		= 'Генератор хлебных крошек:';
$_['text_fpp_breadcrumbs_0']   		= 'По умолчанию';
$_['text_fpp_breadcrumbs_1']   		= 'Генерировать если пустое';
$_['text_fpp_breadcrumbs_2']   		= 'Всегда генерировать';

$_['text_fpp_mode_help']   			= '<span class="help"><b>Прямая ссылка:</b> Прямая ссылка на продукт, категория не включена (прим: /product_name), это станадртное значение опенкарта<br/>
																		  <b>Короткий путь:</b> Короткий путь по умолчанию, может быть изменен запрещенными категориями (прим: /category/product_name)<br/>
																		  <b>Длинный путь:</b> Длинный путь по умолчанию, может быть изменен запрещенными категориями (ex: /category/sub-category/product_name)<br/>
																		  <b>Последняя категория:</b> только последняя категория будет отображена. Если у вас /category/sub-category/product_name ссылка будет /sub-category/product_name<br/>
																		  <b>С производителем:</b> Производитель вместо категорий (ex: /manufacturer/product_name)</span>';
$_['text_fpp_breadcrumbs_help']   	= '<span class="help"><b>По умолчанию:</b> отобображение опенкарта по умолчанию: отображение хлебных крошек исходя из категорий<br/>
																		  <b>Геренрировать если пусто:</b> генерирует хлебные крошки только если их нет,по этому категория хлебных крошек сохраняется (рекомендуется)<br/>
																		  <b>Всегда генерировать:</b> перезаписывает хлебные крошки, по этому на выходе только те, котрые генерирует модуль<br/></span>';
$_['text_fpp_bypasscat'] 			= 'Перезаписываьт пути товара в категориях:';
$_['text_fpp_bypasscat_help'] 		= '<span class="help">Если отключено, ссылка продукта из категорий остается неизменной, чтобы сохранить нормальные хлебные крошки.<br/>
Если включено, ссылка продукта из категорий будет перезаписана путём, сгенерированным модулем. <br> В любом случае каноническая ссылка обновляется с хорошим значением, поэтому google будет видеть только URL-адрес, сгенерированный модулем для данного продукта.</span>';
$_['text_fpp_directcat'] 			= 'Режим пути категории:';
$_['text_fpp_directcat_help'] 		= 'Какую ссылку вы хотите отображать на своем веб-сайте?<br/><b>Прямая ссылка</b>: /category<br/><b>Полная ссылка</b>: /cat1/cat2/category (default)';
$_['text_fpp_homelink'] 			= 'Перезаписать ссылку на главную:';
$_['text_fpp_homelink_help'] 		= '<span class="help">Установить ссылку на главную вида mystore.com из mystore.com/index.php?route=common/home</span>';
$_['text_fpp_depth']   				= 'Максимально уровней:';
$_['text_fpp_depth_help']   		= '<span class="help">Максимальная глубина категории, которую вы хотите отобразить, например, если у вас есть продукт в /cat/subcat/subcat/product установите эту опцию на 2, ссылка станет /cat/subcat/product<br/>Эта опция работает в режиме наибольшего и кратчайшего пути</span>';
$_['text_fpp_unlimited']   			= 'Безлимитно';
$_['text_fpp_brand_parent']   		= 'Производитель родитель:';
$_['text_fpp_brand_parent_help']  	= '<span class="help">Включите производителей в URL-адрес списка производителя.<br/>Например, если ваш список производителей /brand, apple производителя появится таким образом /brand/apple а было /apple</span>';
$_['text_fpp_remove_search']   		= 'Удалить параметры поиска/тегов:';
$_['text_fpp_remove_search_help']   = '<span class="help">Удалить параметр поиска или тега (?search=something, ?tag=something) из URL-адресов продукта в результатах поиска (только для URL-адресов продуктов, а не для самого URL-адреса страницы поиска)</span>';
$_['text_fpp_seo_tag']				= 'СЕО тег:<span class="help">для ссылок тегов (route=product/search&tag=something) определяет ключевое слово для использования для хорошего URL-адреса, например, если вы установите «тег», то результатом будет URL-адрес /tag/something</span>, оставьте пустым для отключения';
$_['entry_category']				= 'Запрещенные категории:<span class="help">Выберите категории, которые никогда не будут отображаться в случае нескольких путей</span>';

// Таб массового обновления
$_['tab_seo_update']       			= 'Массовое обновление';
$_['text_info_update']     			= 'Будьте осторожны при использовании этой функции, так как она перезапишет все ваши ключевые слова.<br/>
Вы можете использовать функцию имитации, чтобы проверить результат до фактического обновления. <br/> Выберите флаги языка для обновления только этих языков.';
$_['text_cleanup']					= 'Очистить:<span class="help">Удалите старые URL-адреса в базе данных, сделайте очистку, если у вас возникли проблемы с некоторыми URL-адресами</span>';
$_['text_cache']					= 'ЧПУ кеш:<span class="help">Генерировать или очистить ЧПУ кеш</span>';
$_['text_redirection']				= 'Динамическая переадресация:<span class="help">Сохраните все фактические URL для дальнейшего перенаправления, затем вы можете изменить ключевое слово СЕО, google сохранит путь.</span>';
$_['text_cache_create_btn']			= 'Генерировать кеш';
$_['text_redirect_create_btn']		= 'Генерировать переадресации';
$_['text_cache_delete_btn']			= 'Очистить кеш';
$_['text_cleanup_btn']				= 'Очистить';
$_['text_cleanup_duplicate_btn']	= 'Удалить дубли ссылок';
$_['text_cleanup_done']				= 'Очистка завершена, %d записей удалено';
$_['text_seo_languages']   			= 'Выберите язык';
$_['text_seo_simulate']    			= 'Симуляция:<span class="help">Никаких изменений не будет, пока включяен этот режим</span>';
$_['text_seo_empty_only']    		= 'Заполнить только пустые значения:<span class="help">Отключите для перезаписи всех значений</span>';
$_['text_seo_redirect']    			= 'Переадресация';
$_['text_seo_redirect_mode']    	= 'ЧПУ переадресайия:<span class="help">Автоматически вставляет переадресацию для старых ссылок</span>';
$_['text_image_name_lang'] 			= 'Имена изображений могут быть установлены только на одном языке, выберите один из них и нажмите «Создать» снова.';
$_['text_enable']   	 		 	= 'Включить';
$_['text_deleted']   	 	 		= 'Удалено';

// Tab cron
$_['tab_seo_cron'] 					= 'Cron';
$_['text_info_cron']				= 'Вы можете сделать массовое обновление с помощью заданий cron, скопируйте файл <b>seo_package_cli.php</b> 
из "_extra files" (желательно в каталог за пределами корня веб-сервера) и сконфигурируйте свой cron с помощью пути к этому файлу.<br/>
Сценарий будет использовать настройки, настроенные на этой странице.<br/>
Ахтунг!!!: Задачи cron не могут генерировать неограниченные элементы (только массовые средства обновления), поэтому в зависимости от ограничений вашего сервера и количества элементов, которые у вас есть, 
вы можете столкнуться с ошибкой при использовании cron, рекомендуется использовать параметр «только пустой», чтобы ограничить количество элементов, котрые вы собираетесь обновлять с помощью cron.';
$_['text_seo_cron_update'] 			= 'Обновить:';
$_['text_clear_logs'] 				= 'Очистить логи';
$_['text_tab_cron_1'] 				= 'Конфигурация';
$_['text_tab_cron_2'] 				= 'Отчет';
$_['text_cli_log_save'] 			= 'Сохранить лог файл';
$_['text_cli_log_too_big'] 			= 'Ваш файл логов слишком большой (%s) для отображения здесь - вы можете загрузить его или очистить с помощью кнопок ниже';

// Tab about
$_['tab_seo_about']			 		= 'О модуле';

$_['text_nothing_changed']    		= 'Нулевое значение';
$_['text_seo_no_language']    		= 'Язвк не выбран';
$_['text_seo_fullscreen']    		= 'Полный экран';
$_['text_seo_show_old']    			= 'Показать старые значения';
$_['text_seo_change_count']    		= 'Pfgbcb bpvtytys';
$_['text_seo_old_value']    		= 'Старые значения';
$_['text_seo_new_value']    		= 'Новые значения';
$_['text_seo_item']    				= 'Пункт';
$_['text_simulation']    			= 'Режим симуляции';
$_['text_write']    				= 'Режим записи';
$_['text_empty_only']    			= 'Только пустые значения';
$_['text_all_values']    			= 'Все значения';
$_['text_seo_update_info']    		= '1. Включить или отключить режим симуляции<br/>
2. Выберите, если вы хотите обновлять только пустые элементы или все элементы<br/>
3. После выбора нажмите на кнопку Генерировать<br/>
4. Результаты отобразятся здесь';
$_['text_seo_simulation_mode']    				= '<span>РЕЖИМ СИМУЛЯЦИИ</span><br/>Никаких изменений не будет в базе данных';
$_['text_seo_write_mode']		    			= '<span>РЕЖИМ ЗАПИСИ</span><br/>Изменения сохранятся';
$_['text_seo_product']							= 'Товар';
$_['text_seo_category']							= 'Категория';
$_['text_seo_manufacturer']						= 'Производитель';
$_['text_seo_information']						= 'Информация';
$_['text_seo_cache']							= 'Имя';
$_['text_seo_cleanup']							= 'Пустая (ссылка)';
$_['text_seo_type_product']						= 'Товары';
$_['text_seo_type_category']					= 'Категории';
$_['text_seo_type_manufacturer']				= 'Производители';
$_['text_seo_type_information']					= 'Информация';
$_['text_seo_type_redirect']					= 'Динамическая переадресация';
$_['text_seo_mode_product']						= 'Товары';
$_['text_seo_mode_category']					= 'Категории';
$_['text_seo_mode_manufacturer']				= 'Производители';
$_['text_seo_mode_information']					= 'Информация';
$_['text_seo_mode_url_alias']					= 'Псевдонимы URL-адресов';
$_['text_seo_mode_duplicate']					= 'Удалить дубли';
$_['text_seo_type_redirection']					= 'Динамическая переадресация';
$_['text_seo_type_report']						= 'Отчет';
$_['text_seo_type_cache']						= 'Кеш';
$_['text_seo_type_cleanup']						= 'Очистить';
$_['text_seo_generator_product']				= 'Товары:';
$_['text_seo_generator_product_desc']			= '<span class="help">Доступные шаблоны:<br/><b>[name]</b> : Название товара<br/><b>[model]</b> : Модель<br/><b>[category]</b> : Название категории<br/><b>[brand]</b> : Название бренда<br/><b>[desc]</b> : Описание<br/><b>[current]</b> : Текущее значение<br/><b>{aa|bb|cc}</b> : Рандомное значение<br/><b>{en}..{/en}</b> : Только для яз<br/><br/>Другие : <b>[parent_category]</b> <b>[upc]</b> <b>[sku]</b> <b>[ean]</b> <b>[jan]</b> <b>[isbn]</b> <b>[mpn]</b> <b>[location]</b> <b>[price]</b> <b>[lang]</b> <b>[lang_id]</b> <b>[prod_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_category']				= 'Категории:';
$_['text_seo_generator_category_desc']			= '<span class="help">Доступные шаблоны:<br/><b>[name]</b> : Название категории<br/><b>[desc]</b> : Описание<br/><b>[current]</b> : Текуущее значение<br/><b>{aa|bb|cc}</b> : Рандомное значение<br/><b>{en}..{/en}</b> : Только для яз<br/><br/><b>[parent]</b> : Раотельское название категории<br/><b>[lowest_price]</b> : Наименьшая цена товара<br/><b>[highest_price]</b> : Наибольшая цена товара<br/><br/>Другие : <b>[lang]</b> <b>[lang_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_information']			= 'Информационный страницы:';
$_['text_seo_generator_information_desc']		= '<span class="help">Доступные шаблоны:<br/><b>[name]</b> : Информационный тайтл<br/><b>[desc]</b> : Описание<br/><b>[current]</b> : Текущее значение<br/><b>{aa|bb|cc}</b> : Рандомное значение<br/><b>{en}..{/en}</b> : Только для яз<br/><br/>Другие : <b>[lang]</b> <b>[lang_id]</b></span>';
$_['text_seo_generator_manufacturer']			= 'Производители:';
$_['text_seo_generator_manufacturer_desc']		= '<span class="help">Доступные шаблоны:<br/><b>[name]</b> : Название производителя<br/><b>[current]</b> : Текукщее значение<br/><b>{aa|bb|cc}</b> : Рандомное значение<br/><b>{en}..{/en}</b> : Только для языка</span>';
$_['text_seo_mode_url']							= 'СЕО УРЛы';
$_['text_seo_generator_redirect']				= 'Генерировать динамические редиректы';
$_['text_seo_mode_title']						= 'Мета тайтлы';
$_['seo_title_prefix']							= 'Префикс';
$_['seo_title_suffix']							= 'Суффикс';
$_['text_seo_mode_h1']				  			= 'СЕО H1';
$_['text_seo_mode_h2']				  			= 'СЕО H2';
$_['text_seo_mode_h3']				  			= 'СЕО H3';
$_['text_seo_mode_image_name']  				= 'Имя картинки';
$_['text_seo_mode_image_alt']  					= 'Альт картинки';
$_['text_seo_mode_image_title']  				= 'Тайтл картинки';
$_['text_seo_mode_keyword'] 					= 'Мета ключевое слово';
$_['text_seo_mode_description']					= 'Мета описание';
$_['text_seo_mode_related']						= 'Рекомендуемые товары';
$_['text_seo_mode_tag']							= 'Теги';
$_['text_seo_mode_create']						= 'Генерировать';
$_['text_seo_mode_delete']						= 'Удалить';
$_['text_seo_report']							= 'Отчет';
$_['text_seo_generator_url']					= 'Геренировать УРЛы';
$_['text_seo_generator_title']					= 'Геренировать Мета тайтлы';
$_['text_seo_generator_keywords'] 				= 'Геренировать Мета ключевые слова';
$_['text_seo_generator_desc']					= 'Геренировать Мета описание';
$_['text_seo_generator_full_desc']				= 'Геренировать Описание';
$_['text_seo_generator_tag']					= 'Геренировать Теги';
$_['text_seo_generator_h1']						= 'Геренировать СЕО H1';
$_['text_seo_generator_h2']						= 'Геренировать СЕО H2';
$_['text_seo_generator_h3']						= 'Геренировать СЕО H3';
$_['text_seo_generator_imgalt']					= 'Геренировать Альт картинок';
$_['text_seo_generator_imgtitle']				= 'Геренировать Тайтл картинок';
$_['text_seo_generator_imgname'] 				= 'Геренировать Названия картинок';
$_['text_seo_generator_related'] 				= 'Геренировать Рекомендуемые товары';
$_['text_seo_generator_related_no']				= 'Кол-во:';
$_['text_seo_generator_related_relevance'] 		= 'Релевантность (0-10):';
$_['text_seo_generator_related_samecat'] 		= 'Некотрые категории';
$_['text_query']								= 'Запрос';
$_['text_keyword']								= 'Ключевое слово';
$_['text_status']								= 'Статус';
$_['text_empty']								= 'Пусто';
$_['text_duplicate']							= 'Дубликат';
$_['text_report']								= 'Отчет';
$_['text_url_alias_report_btn']					= 'Отчет псевдонима Url';

$_['text_seo_result']      						= 'Результат:';

$_['text_module']          						= 'Модули';
$_['text_success']         						= 'Отлично: Вы изменили значения СЕО модуля!';

$_['text_man_ext']				 				= 'Расширение производителей';

$_['text_seo_confirm']		 					= 'Вы уверены?';
$_['text_description']		 					= 'Описания';


// Full product path

// Help sections

$_['tab_info_request'] = 'Запросить заголовки';
$_['title_common_overview'] = 'ЧПУ компоненты';
$_['text_info_common_overview'] = '
<p><b>Краткие описания компонентов ЧПУ.</b></p>
<h4>Абсолютные ссылки</h4>
<p>Используйте этот компонент, чтобы установить дружественный URL-адрес для любого настраиваемого модуля, работает с полным URL-адресом вместо ссылки ключевого слова.</p>
<p>http://website.com/index.php?<b>route=blog/blog&path=12&post=32</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/<b>blog/blog-cat/this-is-a-blog-post</b></p>
<h4>Common Page Url</h4>
<p>Use this component to set friendly url to default opencart pages (account, contact, checkout, ...), handles only the route= parameter.</p>
<p>http://website.com/index.php?<b>route=account/register</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/<b>my-account/register</b></p>
<h4>Param url</h4>
<p>This component lists the seo url parameters from custom modules, so you can quick check them, you can create new parameters but it may not work on some modules so absolute url is recommended because it will work in any case.</p>
<p>http://website.com/some-category?<b>super_filter=42</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/some-category/<b>filter-blue</b></p>
</ul>';
$_['text_info_absolute'] = '
<h4>Absolute Url - Handle any custom module url</h4>
<p>Opencart is working by default with url keywords, for example <b>/desktop/pc/some-computer</b>, from this url opencart is searching in database each part to determine to what it relates (category, product, information, etc), then it will compute this link to an understandable one for the system which will look like <b>index.php?route=product/product&path=12_31&product_id=54</b>.</p>
<p>With absolute url component you can define an url not using the keyword part but the full url itself, it is no use for product/information/categories etc but it can be very handy for making to work with any custom module.</p>
<p>It is working with unlimited parameters in source url and unlimited levels in seo url.</p>
<h4>Set up a new absolute url</h4>
<p>Example, transform <b>http://website.com/index.php?route=blog/blog&post=32</b> into <b>http://website.com/blog/this-is-a-blog-post</b>.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span></li>
<li>Insert in query field <b>blog/blog&post=32</b> (do not insert index.php?route=)</li>
<li>in Full seo url field <b>blog/this-is-a-blog-post</b></li>
</ol>
</ul>';
$_['text_info_common'] = '
<h4>Common Page Url - Give friendly url to default opencart pages (account, contact, checkout, ...)</h4>
<p>By default opencart is not rewritting the common page urls, they remain this way <b>index.php?route=account/login</b>.</p>
<p>With common page url component you can define an seo url for all these pages </p>
<p>For example you can rewrite <b>index.php?route=account/register</b> to <b>register</b>, just put <b>account/register</b> in query (do not insert index.php?route=), and put <b>register</b> in seo url field.</p>
<p>Here you can not insert any parameter, for example <b>account/register&amp;param=value</b> won\'t work, you have to use absolute url for such link or insert the parameter into parameter url</p>
<h4>Get predefined urls</h4>
<p>Complete SEO comes with predefined urls for all common opencart pages, there various languages available and they will be automatically retrieved for current selected language if exists, if not it will get english urls instead.</p>
<p>Warning: using restore default urls will replace all existent common page urls listed for current language.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-caret-down"></i></span> on the bottom button to get access to advanced options.</li>
<li>Then click on <span class="gkd-badge"><i class="fa fa-magic" style="color:#FB7C00"></i> Restore default URLs</span></li>
<li>If the keywords are available for current language they will be displayed, if not english language will be displayed and you will have to translate.</li>
<li>You translated a new language and want us to integrate in main package? then click on <span class="gkd-badge"><i class="fa fa-save" style="color:#4276D2"></i> Export URLs</span> and send us export file at support@geekodev.com</li>
</ol>
<h4>Set up a new common page url</h4>
<p>Example, transform <b>http://website.com/index.php?route=account/register</b> into <b>http://website.com/my-account/register</b>.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span></li>
<li>Insert in query field <b>account/register</b> (do not insert route=)</li>
<li>in Full seo url field <b>my-account/register</b></li>
</ol>
</ul>';
$_['text_info_special'] = '
<h4>Param url - Manage seo keywords of parameters in url</h4>
<p>If you have a custom module which is handling seo keywords, its keywords will generally appear there, so you can easily give a look on them and change if necessary.</p>
<p>If your custom module does not manage seo url automatically then it is recommended to use Absolute Url component to handle the urls. You can also use a combination of Common Page and Param url to handle it but Absolute url is easier for that, so this component is recommended only for view and not for url creation.</p>
<h4>Set up a new redirection</h4>
<p><span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span> click on this button and follow the instructions to set your url redirection.</p>
</ul>';
$_['text_info_404'] = '
<h4>Not found (404) manager</h4>
<p>This section lists all url accessed on your website that are actually not existant or that opencart system have not been able to forward to any content. For example when you arrive on such page:</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/not_found.png" alt=""/></p>
<p>In such case Complete SEO Package will automatically save this url so you will be able to easily check all not found urls in this table and how many times they have been requested.</p>
<h4>Create a redirection from a not found url</h4>
<p>Click on the button <img src="view/seo_package/img/help/btn_plus.png"/> to a easily add a redirection for this url, once added your redirection will appear into "Url redirection" tab, and here the url will appear in <span class="text-success">green color</span> to indicate that this url already have a redirection.</p>
<h4>Remove actual entries</h4>
<p>These entries are for your information only, there is no impact to remove them, to do so just click on one of the following buttons:</p>
<ul class="list-unstyled">
<li style="margin-top:12px"><span class="gkd-badge"><i class="fa fa-minus" style="color:#ED5555"></i> Remove redirected entries</span> this will remove all urls marked as <span class="text-success">green</span> which means any url that already have his redirection set</li>
<li style="margin-top:12px"><span class="gkd-badge"><i class="fa fa-close" style="color:#ED5555"></i> Remove all entries</span> this will remove all urls in this table, marked green or not, don\'t worry this is not deleting the redirections made on these urls</li>
</ul>';
$_['text_info_redirections'] = '
<h4>Url redirection</h4>
<p>Here you can define your own URL redirections, this is using the redirection 301, it means search engines will consider the new url as the valid one.</p>
<p>If you need to change the URL of a page as it is shown in search engine results, we recommend that you use a server-side 301 redirect. This is the best way to ensure that users and search engines are directed to the correct page. The 301 status code means that a page has permanently moved to a new location.</p>
<p>301 redirects are particularly useful if you have any url not found on your website.</p>
<h4>Set up a new redirection</h4>
<p><span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span> click on this button and follow the instructions to set your url redirection.</p>';
$_['text_info_request'] = '<h4>Request headers</h4>
<p>Request headers are part of the HTTP protocol, they are sent on each request made to the server.<br/>Here you will be able to change some parameters related to request headers, such optimizations can improve performance for the end user and also for search engine crawling robots.</p>
<h5>Last-Modified</h5>
<p>Include the last modified date of the actual item, improves performance for user (browser will fetch page from cache if not updated) and for crawling robots. For products the date will be the one of the last edit of product or the one of the last review if any. It is highly recommended to activate this setting.</p><p><img class="img-thumbnail" src="view/seo_package/img/help/headers-last-modified.png" alt=""/></p>';
$_['help_fb_appid_tab'] = 'Facebook App ID';
$_['help_microdata'] = '
<h4>Google microdata</h4>
<p>Microdata is widely used by search engines to format the search result in better way, for example a product can display the price and review rating directly in search results : </p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/microdata-product.jpg" alt=""/></p>
<p>Complete SEO Package is using the latest JSON-LD format to include the microdata on your website. Basic informations are included (category, description, image, price, stock) and you can select extra data you want to display.</p>
<h4>Benefits of using microdata</h4>
<p><ul>
  <li>Eye catching results - Drawing a search users attention from your competitors and to your own result.</li>
  <li>Potential CTR increase - Possibly increasing click through rates and lowering the chance of the user bouncing as they have more information on the page before clicking through.</li>
  <li>Providing quality results - Offering results that are closer to user specifications.</li>
</ul></p>
<h4>Testing tool</h4>
<p>Use the following testing tool to check your actual microdata: <a href="https://search.google.com/structured-data/testing-tool" target="_blank">Google structured data testing tool</a></p>
';
$_['help_fb_appid'] = '
<h4>Facebook App ID</h4>
<p>You must fill your facebook App ID in order to get this feature working, you will find it in the settings of your developper panel: <a href="http://facebook.com/developers">http://facebook.com/developers</a>.</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/settings_app-id.gif" alt=""/></p>
';
$_['help_fb_setup_tab'] = 'How to use Facebook Opengraph';
$_['help_fb_setup']	= '
<h4>Install the Facebook Developer Application</h4>
<p>The first step in creating an application in Facebok is to install the Facebook Developer application.</p>
<p>To do that, log in to Facebook and then visit the URL <a href="http://facebook.com/developers">http://facebook.com/developers</a>.</p>
<p>If this is the first time you’ve installed the Developer Application, you will see the Request for Permission dialog show below:</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/permission.jpg" alt="" /></p>
<p>Click the <b>Allow</b> button to proceed.</p>
<h4>Creating the Facebook Application for your Website</h4>
<p>Now that you have the Developer App installed, click on the<b> Create New App</b> button.<br/><img class="img-thumbnail" src="view/seo_package/img/help/create-new-app.gif" alt=""/></p>
<p>Give your application an "App Display Name" (the name displayed to users).</p>
<p>For purposes of this tutorial, you don’t need to have a "Namespace".</p>
<p>Click the "I agree to Facebook Platform Policies" box; then click the <b>Continue</b> button.<br/><img class="img-thumbnail" src="view/seo_package/img/help/dialog_new-app.gif" alt=""/></p>
<p>On the next screen, enter the security phrase and then click <b>Submit</b>.</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/new-app_captcha.gif" alt=""/></p>
<p>There are a lot of options you can tweak related to your application. In this post, we are going to focus on the basics needed to get your website set up with a Facebook App ID.</p>
<h4>The Settings Tab</h4>
<p>This is where you do the basic set up for your app</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/settings_app-id.gif" alt=""/></p>
<p>App ID is now set up. Your App ID is the value you’ll be using to integrate your website with Facebook’s APIs so you can add the Social Plugins (Like Button, Send Button, Comments Box, etc.).</p>
<p>You don’t need to add an icon. If your website has a favicon, it will be displayed next to your site’s URL in Facebook Insights.</p>
<p><b>Basic info:</b></p>
<p><ul>
<li><b>App Display Name:</b> Make this the same as the original value you provided</li>
<li><b>App Namespace:</b> Leave blank</li>
<li><b>Contact Email:</b> Where you want Facebook to send emails regarding your app</li>
<li><b>App Domain:</b> just put “mydomain.com” where “mydomain.com” is your website’s domain URL (TLD)</li>
<li><b>Category:</b> Select a category from the pulldown list (optional)</li>
</ul></p>
<p>Your website is now an “object” in Facebook’s Open Graph, with its own App ID.</p>
';
$_['help_flag_mode'] = '
<h4>Tag after domain</h4>
<p>Language prefix mode permits to add the language code just after the domain name:</p>
<p><code>http://example.com/<b>en</b></code><br/><code>http://example.com/<b>fr</b></code>
<p>It can be useful to have a good separation between each language in multilingual websites.</p>
<p>This parameter can be enabled anytime and take effect immediately, there is no need to re-generate the urls.</p>
<h4>Extra options</h4>
<table class="table table-bordered">
<tr><th style="width:220px">Option</th><th>Effect</th></tr>
<tr><td><code>Short tag</code></td><td>Display <b>/en</b> instead of <b>/en-gb</b> in case you have full format defined</td></tr>
<tr><td><code>No tag for default</code></td><td>Default language won\'t display the language tag</td></tr>
<tr><td><code>Tag in uppercase</code></td><td>Display tag in uppercase <b>/EN, /FR</b></td></tr>
</table>
';
$_['help_store_mode'] = '
<h4>Tag as subdomain</h4>
<p>Enable this option if you want your links to be written with specific store depending the language. For example if you have 2 stores defined like this :</p>
<p><code>http://<b>en</b>.domain.com</code><br/><code>http://<b>fr</b>.domain.com</code></p>
<p>By default opencart allows to change language but stay on same domain, if you enable this option and change the language, you will be redirected to the other domain. Also the hreflang links will be correctly updated with corresponding store url.</p>
<p>This setting is using your stores configuration, so you have to configure the stores correctly to get this working, also note that this is not limited to subdomains, you could also use separate domains names for each language:</p>
<p><code>http://<b>english-store</b>.com</code><br/><code>http://<b>french-store</b>.com</code></p>
<p>If you make any modification on configuration in Settings > Stores, come back here and save settings again.</p>
<h5>Actual configuration</h5>
<p>In this section you can see how are actually binded your stores to each language, you must have only one store for each language in order to get this option working properly, if a store have no defined language you will get the message "<span class="text-danger">No language defined</span>", in this case it is necessary you define a language for this store in Settings > Stores.</p>
';


// Error
$_['error_permission'] 				= 'Ахтунг!!!: У вас нет прав для редактирования этого модуля!';
$_['error_module_disabled'] 		= 'Complete SEO Package полностью отключен, вы можете включить его в вкладке СЕО конфигурации.';
$_['error_friendly_disabled'] 		= 'Ахтунг!!!:: Компонент ЧПУ специальных страниц отключен, вы можете редактировать все значения, но они будут активны только тогда, когда вы активируете этот компонент в настройке СЕО';
$_['error_404_disabled'] 			= 'Ахтунг!!!:: Менеджер компонента 404 отключен, запись не найденных страниц будет активна только при активации этого компонента в настройке СЕО';
$_['error_absolute_disabled'] 		= 'Ахтунг!!!:: Абсолютный URL-адрес отключен, вы можете редактировать все значения, но они будут активны только при активации этого компонента в настройке СЕО';
$_['error_redirect_disabled'] 		= 'Ахтунг!!!:: Компонент перенаправления УРЛ отключен, вы можете редактировать все значения, но они будут активны только тогда, когда вы активируете этот компонент в настройке СЕО';
?>