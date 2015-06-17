/**
 * Базовая конфигурация теста на знание Symphony2
 * */
(function () {
	$(document).ready(init);
	function cover() {
		vp = getViewport();
		$(document.body).css('height', 'auto');
		if ( $(document.body).height() < vp.h ) {
			$(document.body).css('height', '100%');
		}
	}
	function init() {
		/** @var глобальный объект - экземпляр базового конфигуратора теста по паттернам*/
		window.UserTest = new TestEngine();
		//Конфигурация
		UserTest.configTime(60);
		UserTest.configLives(5);
		UserTest.defaultScorePerAnswer = 10;
		UserTest.useSkipThershold = true;
		UserTest.skipThershold = 15;
		//Вопросы
		UserTest.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6. Введите команду для генерации бандла HelloBundle", a:"php app/console generate:bundle --namespace=Acme/HelloBundle"});
		UserTest.quests.push({q:"Что такое Acme?", a:"Имя компании по умолчанию."});
		UserTest.quests.push({q:"Укажите путь к YML файлу конфигурации соединения с базой данных по умолчанию (от корня проекта symfony 2.6.6, например app/config/... или src/Acme/YourBundle/Resources/config/...)", a:"app/config/parameters.yml"});
		UserTest.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для создания базы данных", a:"php app/console doctrine:database:create"});
		UserTest.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для создания класса модели c именем Product в пакете AcmeHelloBundle содержащей три поля: имя, описание и цена. Типы полей: строка в 255 символов, текст, дробное число.", a:"php app/console doctrine:generate:entity --entity=\"AcmeHelloBundle:Product\" --fields=\"name:string(255) description:text price:float\""});
		UserTest.quests.push({q:"Создалась ли таблица базы данных в результате предыдущей команды?", a:"Нет"});
		UserTest.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для генерации таблицы базы данных на основе файлов конфигурации, создавшихся в результате предыдущих действий", a:"php app/console doctrine:schema:update --force"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите получить доступ к методам экземпляра класса EntityManager, присвоив его переменной $em. Введите соответствущую строку php кода.", a:"$em = $this->getDoctrine()->getEntityManager();"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите передать объект $product класса Product экземпляру класса EntityManager (экземпляр у вас уже определен в переменной $em). Введите соответствущую строку php кода.", a:"$em->persist($product);"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите записать последние изменения в базу данных. Введите соответствущую строку php кода.", a:"$em->flush();"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите получить в переменную $repository объект, который предоставит вам методы поиска продуктов по значениям идентификатора и других полей модели. Введите соответствущую строку php кода.", a:"$repository = $this->getDoctrine()->getRepository(\"AcmeHelloBundle:Product\");"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php. Вы хотите получить в переменную $request объект, который предоставит вам методы доступа к переменным POST, GET и сессии (и еще много всего). Введите соответствующую строку php кода.", a:"$request = $this->getRequest();"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php. У вас есть объект $request из предыдущего вопроса. Вам нужен в переменной $session объект, предоставляющий доступ к сессии пользователя. Введите соответствующую строку php кода.", a:"$session = $request->getSession();"});
		UserTest.quests.push({q:"Вы хотите сделать в своем контроллере доступным SecurityContext. Напишите соответствующую инструкцию use (use Symfony\\ ... SecurityContex...; ) подключающую необходимый компонент.", a:"use Symfony\\Component\\Security\\Core\\SecurityContext;"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $request = $this->getRequest();. Напишите строку php кода, возвращающую true если произошла ошибка аутентификации", a:"$request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $session = $this->getRequest()->getSession();. Напишите строку php кода, возвращающую из сессии ошибку аутентификации в переменную $error", a:"$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);"});
		UserTest.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $session = $this->getRequest()->getSession();. Напишите строку php кода, возвращающую из сессии последнее введенное  в форму логина имя пользователя,  $last_name = ...", a:"$last_name = $session->get(SecurityContext::LAST_USERNAME);"});
		UserTest.quests.push({q:"Вы редактируете файл app/config/security.yml. По умолчанию в настройках безопасности проекта симфони 2.6.6 сконфигурирована защишённая область demo_secured_area. Вы хотите задать конфигурацию безопасности для всего сайта. Как назовёте секцию конфигурации и в какую секцию ее поместите? Ответ дайте в форме section_name в parent_section_name.", a:"secured_area в firewalls"});
		UserTest.quests.push({q:"Вы редактируете файл app/config/security.yml. Вы добавили секцию secured_area в конфигурацию. Вы хотите задать конфигурацию безопасности так, чтобы брандмауер срабатывал при запросе любого url на вашем сайте. Введите соответствующую строку yml конфигурации.", a:"pattern: ^/"});
		UserTest.quests.push({q:"Вы редактируете файл app/config/security.yml. Брандмауер срабатывает при запросе любого url на вашем сайте, но вы хотите дать анонимным пользователям возможность просматривать его страницы. Введите соответствующую строку yml конфигурации.", a:"anonymous: ~"});
		UserTest.quests.push({q:"Вы редактируете файл app/config/security.yml. Что значит значение ключа конфигурации ~?. Например, что значит ~ в строке yml файла 'anonymous: ~'", a:"По умолчанию"});
		UserTest.quests.push({q:"Вы редактируете файл app/config/security.yml. Добавьте в секцию secured_area настройку, указывающую, что вы хотите использовать html форму логина (с путями по умолчанию)", a:"form_login: ~"});
		UserTest.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Перечислите через запятую два ключа, задающие пути, использующиеся при действии логина.", a:"check_path, login_path"});
		UserTest.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Введите значение ключа login_path по умолчанию.", a:"/login"});
		UserTest.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Введите значение ключа check_path по умолчанию.", a:"/login_check"});
		UserTest.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Вы задали свои оригинальные значения для путей к форме логина и скрипту проверки успешной аутентификации. Что необходимо ещё сделать в другом файле конфигурации, чтобы логически завершить это действие? Ответ дайте в форме \"У**ть м**ы в файле app/...\"", a:"Указать маршруты в файле app/config/routing.yml"});
		UserTest.quests.push({q:"Надо ли указывать маршруты для путей секции form_login, если их значения оставлены по умолчанию? (Да/Нет)", a:"Да"});
		UserTest.quests.push({q:"Вы работаете в \"свежеустановленом\" проекте симфони 2.6.6, вы не конфигурировали .htaccess  и все url в вашем проекте начинаются с /web/app_dev.php/ или /web/app.php/. Вы добавили аутентификацию пользователя через форму логина и хотите, чтобы при запросе url /web/app_dev.php/logout пользователь \"разлогинился\". Какую минимально необходимую строку надо добавить в секцию secured_area в файле app/config/security.yml?", a:"logout: ~"});
		UserTest.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вам надо ещё создать некий маршрут в файле. Какое имя маршрута и в каком файле? Ответ дайте в форме route_name в файле app/....", a:"logout в файле app/config/routing.yml"});
		UserTest.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы создали маршрут logout в файле app/config/routing.yml. В секции logout должна быть минимум одна строка. Наберите её.", a:"pattern: /logout"});
		UserTest.quests.push({q:"Logout заработал, но после разлогина вас перенаправляет на страницу /web/app_dev.php/, а вы хотите на /web/app_dev.php/hello/Anonymous. В каком файле, в какой секции и что надо ввести для этого?. Ответ наберите в виде app/.., section_name, key: value.", a:"app/config/security.yml, logout, target: /hello/Anonymous"});
		UserTest.quests.push({q:"Вы набираете код внутри контроллера. Как получить объект авторизованного пользователя?. ($user = $this->...;)", a:"$user = $this->get(\"security.context\")->getToken()->getUser();"});
		UserTest.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект авторизованного пользователя в переменную $user с помощью строки кода $user = $this->get(\"security.context\")->getToken()->getUser(); Какой тип переменной $user если пользователь НЕ авторизован?. Ответ дайте в виде имени типа данных php или Symfony, например TestUser, integer, string, bool, array.", a:"string"});
		UserTest.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект авторизованного пользователя в переменную $user с помощью строки кода $user = $this->get(\"security.context\")->getToken()->getUser(); Вы собираетесь получить объект шифровальщика в переменную $encoder. Введите соответствующую строку php кода ($encoder = ...;).", a:"$encoder = $this->get(\"security.encoder_factory\")->getEncoder($user);"});
		UserTest.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект шифровальщика в переменную $encoder с помощью строки кода $encoder = $this->get(\"security.encoder_factory\")->getEncoder($user); $user при этом имеет UserInterface. Вы собираетесь зашифровать пароль, хранящийся в переменной $password. Введите соответствующую строку php кода ($password = ...;).", a:"$password = $encoder->encodePassword($password, $user->getSalt());"});
		
		UserTest.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что пароль для данного типа пользователей следует шифровать алгоритмом bcrypt. Введите соответствующую строку yml конфигурации.", a:"Acme\\HelloBundle\\Entity\\CUser: { algorithm: bcrypt }"});
		UserTest.quests.push({q:"В какой секции yml файла конфигурации должна располагаться строка - ответ на предыдущий вопрос?", a:"encoders"});
		
		UserTest.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что информацию о пользователях следует хранить в экземплярах именно этого класса. Как называется секция, существующая в дефолтном файле app/config/security.yml в секции security, которую вы будете редактировать для достижения поставленной цели?", a:"providers"});
		UserTest.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы редактируете дочернюю секцию providers provider_name. Перечислите имена трех ключей, которые вам необходимо добавить.", a:"entity, class, property"});
		UserTest.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что информацию о пользователях следует хранить в экземплярах именно этого класса. Введите значение ключа class в этом случае.", a:"Acme\\HelloBundle\\Entity\\CUser"});
		UserTest.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы должны добавить еще один ключ помимо ключа class, с определеннным значением. Введите эту конкретную строку в yml формате. (Ответ в формате ключ: значение)", a:"property: username"});
		UserTest.quests.push({q:"Как должна называться секция, в которой должны располагаться ключи  class и property (в контексте четырех последних вопросов)", a:"entity"});
		UserTest.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. С целью указать, что информацию о пользователях следует хранить в экземплярах именно этого класса вы добавили непосредственно в секцию providers строку entity: { class: Acme\\HelloBundle\\Entity\\CUser, property:username }. Будет ли работать эта конфигурация?", a:"Нет"});
		UserTest.quests.push({q:"Чего не хватает в предыдущей конфигурации? (Ответ одним словом, \"Не хватает ...\")", a:"провайдера"});
		UserTest.quests.push({q:"Вы сгенерировали пакет --namespace=Acme/HelloAnnotationBundle. Вы хотите указать для indexAction шаблон test.html.twig, который лежит в одном каталоге со сгенерированным по умолчанию шаблоном index.html.twig. Введите соответствующую аннотацию @Template", a:"@Template(\"AcmeHelloAnnotationBundle:Default:test.html.twig\")"});
		UserTest.quests.push({q:"Вы набираете код в методе контроллера, хотите вернуть данные array(\"name\" => $name) в json формате. В документации symfony 2.6 для этого используются две строки php кода. Введите первую из них (кавычки в ответе используйте двойные). ($response = ...)", a:"$response = new Response( json_encode( array(\"name\" => $name) ) );"});
		UserTest.quests.push({q:"Вы набираете код в методе контроллера, хотите вернуть данные в json формате. В документации symfony 2.6 для этого используются две строки php кода. Введите вторую из них (кавычки в ответе используйте двойные). ($response->...)", a:"$response->headers->set(\"Content-Type\", \"application/json\");"});
		UserTest.quests.push({q:"Вы работаете в \"свежеустановленом\" проекте симфони 2.6.6, вы не конфигурировали .htaccess  и все url в вашем проекте начинаются с /web/app_dev.php/ или /web/app.php/. Вы указали атрибут html формы action=\"{{ path('acme_user_add') }}\" и хотите чтобы форма отправлялась по адресу /web/app_dev.php/user/add. Введите соответствующую аннотацию. ", a:"@Route(\"/user/add\", name=\"acme_user_add\")"});
		UserTest.quests.push({q:"Вы набираете код в методе контроллера, хотите сделать редирект по маршруту login. Введите соответcтвующую строку php кода. (return ...)", a:"return $this->redirectToRoute(\"login\")"});
		UserTest.quests.push({q:"Вы набираете код в определении модели, хотите сделать обязательным для ввода поле password. Подключите модуль, позволяющий использовать Assert . (use ... AS Assert;)", a:"use Symfony\\Component\\Validator\\Constraints AS Assert;"});
		UserTest.quests.push({q:"Вы набираете код в определении модели, хотите сделать обязательным для ввода поле password. Введите соответcтвующую строку аннотации. (@...)", a:"@Assert\\NotBlank()"});
		UserTest.quests.push({q:"Измените ответ на предыдущий вопрос так, чтобы сообщение о пустом поле пароля сменилось на \"Password required\".", a:"@Assert\\NotBlank(message=\"Password required\")"});
		UserTest.quests.push({q:"Вы набираете код в определении модели. Подключите модуль, позволяющий использовать UniqueEntity . (use Symfony\\...;)", a:"use Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntity;"});
		UserTest.quests.push({q:"Вы набираете код в определении модели. В модели есть два поля (one, two), значения каждого из которых должны быть уникальными для каждой записи. Введите соответствующую аннотацию (аннотации) UniqueEntity . (@...[\n@...])", a:"@UniqueEntity(\"one\")\n@UniqueEntity(\"two\")"});
		UserTest.quests.push({q:"Вы набираете код в определении модели. В модели есть два поля (one, two), значения которых должны быть уникальными для каждой записи (составной ключ). Введите соответствующую аннотацию (аннотации) UniqueEntity . (@...[\n@...])", a:"@UniqueEntity(fields={\"one\", \"two\"})"});
		UserTest.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email. Вам необходимо создать класс, реализующий некий интерфейс. Введите название интерфейса.", a:"UserProviderInterface"});
		UserTest.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе, вы создали класс Acme/HelloBundle/Entity/CUserProvider.php. Введите название метода, в котором логично сделать проверку на то, активировал уже пользователь свой аккаунт или нет.", a:"loadUserByUsername"});
		UserTest.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email. Вам необходимо зарегистрировать класс Acme/HelloBundle/Entity/CUserProvider как сервис. Введите название xml файла, в котором логично это сделать. (dirname/...)", a:"src/Acme/HelloBundle/Resources/config/services.xml"});
		UserTest.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email, для этого вы создали класс, реализующий UserProviderInterface  и зарегистрировали его как сервис в xml файле. Вы хотите, чтобы в конструктор вашего класса передавался экземпляр класса Doctrine. Введите соответствующую строку xml конфигурации. (<argument...)", a:"<argument type=\"service\" id=\"doctrine\" />"});
		UserTest.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email, для этого вы создали класс, реализующий UserProviderInterface  и зарегистрировали его как сервис с id=\"my_user_provider\". . Введите имя yml файла конфигурации, имя секции в этом файле, в которых вы укажете необходимость использовать ваш провайдер и yaml конфигурацию одной строкой. Формат ответа: имя файла (app/...), имя секции, provider: { ключ: значение }", a:"app/config/security.yml, providers, provider: { id: my_user_provider }"});
		UserTest.quests.push({q:"Для достижения цели, о которой шла речь в предыдущих пяти вопросах, класс модели пользователя должен реализовывать два интерфейса. Перечислите их через запятую", a:"UserInterface, EquatableInterface"});
		UserTest.quests.push({q:"Где проще всего посмотреть пример реализации UserProviderInterface? Ответ - имя класса, входящего в symfony 2.6.6 \"из коробки\"", a:"EntityUserProvider"});
		UserTest.quests.push({q:"Вы набираете код в контроллере. Введите строку php кода, позволяющую получить параметр path маршрута my_personal_route. ($this->...;)", a:"$this->get(\"router\")->getRouteCollection()->get(\"my_personal_route\")->getPath();"});
		UserTest.quests.push({q:"Вы с помощью doctrine создали класс сущности CUser в бандле AcmeHelloBundle и одноименную таблицу в базе данных. Теперь вы хотите получить общее количество пользователей подтвердивших свой email, используя SQL запрос \"SELECT COUNT(u.id) FROM CUser AS u WHERE u.email_verify = 1;\" который вы планируете передать в метод EntityManager::createQuery(); Выполнится ли запрос? (Да/Нет)", a:"Нет"});
		UserTest.quests.push({q:"Что на что надо заменить в запросе \"SELECT COUNT(u.id) FROM CUser AS u WHERE u.email_verify = 1;\" для успешного использования метода EntityManager::createQuery();  (* на *)", a:"CUser на AcmeHelloBundle:CUser"});
		UserTest.quests.push({q:"Какой метод логично использовать для получения результата запроса из последних двух вопросов? (methodName();)", a:"getSingleResult();"});
		UserTest.quests.push({q:"Укажите тип данных php или класс Symfony 2.6 который вернет метод getSingleResult()", a:"array"});
		UserTest.quests.push({q:"Вы выполнили код $res = $em->createQuery(\"SELECT COUNT(u.id) FROM AcmeHelloBundle:CUser AS u WHERE u.email_verify = 1;\")->getSingleResult(); В каком элементе массива $res содержится запрошеное количество? (Ответ - число)", a:"1"});
		UserTest.quests.push({q:"Вы определили в контроллере строковую переменную содержащую элементы html разметки. Значение передается в twig шаблон как messages. Как вывести в twig шаблоне значение messages без html тегов? (Ответ - {{ code }})", a:"{{ messages|raw }}"});
		UserTest.quests.push({q:"Как вывести в twig шаблоне версию twig?", a:"{{ constant('Twig_Environment::VERSION') }}"});
		UserTest.quests.push({q:"Вы хотите посмотреть все переменные доступные в twig шаблоне. Как называется подходящая twig функция?", a:"dump"});
		UserTest.quests.push({q:"Вы хотите посмотреть все переменные доступные в twig шаблоне. Что нужно сделать в \"свежем\" symfony 2.6 проекте, чтобы функция dump стала доступна? (Ответ из двух слов З**ть с*.)", a:"Зарегистрировать сервис"});
		UserTest.quests.push({q:"Вы хотите посмотреть все переменные доступные в twig шаблоне используя функцию twig dump. Для этого вы определяете соответствующее расширение twig как сервис в файле NamespaceYourBundle/Resources/config/services.xml. Введите значение атрибута id.", a:"twig.extension.debug"});
		UserTest.quests.push({q:"Вы хотите посмотреть все переменные доступные в twig шаблоне используя функцию twig dump. Для этого вы определяете соответствующее расширение twig как сервис в файле NamespaceYourBundle/Resources/config/services.xml. Введите значение атрибута class.", a:"Twig_Extension_Debug"});
		UserTest.quests.push({q:"Вы хотите посмотреть все переменные доступные в twig шаблоне используя функцию twig dump. Для этого вы определяете соответствующее расширение twig как сервис в файле NamespaceYourBundle/Resources/config/services.xml. Введите XML таг, вложенный в таг service.", a:"<tag name=\"twig.extension\" />"});
		UserTest.quests.push({q:"Вы набираете код в контроллере. Как получить реальный url на сайте, ассоциированный с маршрутом my_route", a:"$this->generateUrl(\"my_route\");"});
		UserTest.quests.push({q:"Вы хотите определить класс формы для редактирования данных пользователя AcmeHelloBundle:CUser, чтобы использовать формы симфони в вашем проекте. Введите значение namespace (namespace ...;).", a:"namespace Acme\\HelloBundle\\Form\\Type;"});
		UserTest.quests.push({q:"Вы хотите определить класс формы для редактирования данных пользователя AcmeHelloBundle:CUser, чтобы использовать формы симфони в вашем проекте. Введите инструкции use подключающие необходимые компоненты в классе CUserType.", a:"use Symfony\\Component\\Form\\AbstractType;\nuse Symfony\\Component\\Form\\FormBuilderInterface;"});
		UserTest.quests.push({q:"Вы хотите определить класс формы CUserType для редактирования данных пользователя AcmeHelloBundle:CUser, чтобы использовать формы симфони в вашем проекте. Перечислите названия двух необходимых к реализации методов в классе CUserType.", a:"buildForm, getName"});
		UserTest.quests.push({q:"Перечислите типы аргументов метода buildForm.", a:"FormBuilderInterface, array"});
		UserTest.quests.push({q:"Вы хотите, чтобы имя пользователя было не менее 2 символов и не более 15-ти. Введите сответствующую аннотацию.", a:"@Assert\\Length(min=2, max=15)"});
		UserTest.quests.push({q:"Вы хотите запретить доступ пользователям на страницу /profile. Введите имя секции в security.yml и строку, которую надо туда добавить, если метод getRoles в вашем классе пользователя возвращает одну роль ROLE_USER. (Имя секции, строка)", a:"access_control, -{ path: ^/profile, roles: ROLE_USER }"});
		UserTest.quests.push({q:"Вы хотите использовать REST подход при проектировании вашего сайта и для этого редактирование записей выполняете в ответ на запросы использующие метод PATCH. При этом вы используете формы и соответственно класс, реализующий FormBuilderIneface. Какая инструкция необходима в теле метода buildForm(FormBuilderInterface $builder, array $options), чтобы в контроллере вызов $form->handleRequest() работал корректно? ($builder->...;)", a:"$builder->setMethod(\"PATCH\");"});
		UserTest.quests.push({q:"Функциональные тесты. Напишите инструкцию use для подключения необходимого для их написания класса? (use ...;)", a:"use Symfony\\Bundle\\FrameworkBundle\\Test\\WebTestCase;"});
		UserTest.quests.push({q:"Функциональные тесты. От какого класса должен наследоваться класс, релизующий тесты контроллера?", a:"WebTestCase"});
		UserTest.quests.push({q:"Функциональные тесты. Введите строку php кода, возвращающую в переменную $client объект, позволяющий выполнять действия имитирующие действия браузера. ($client = ...;)", a:"$client = static::createClient();"});
		UserTest.quests.push({q:"Функциональные тесты. Вы хотите, чтобы код\n $form = $client->request(\"GET\", $routeName)-> selectButton($a)-> form($b, $c); $client->submit($form); отправил форму методом PATCH. Какая из переменных $a, $b, $c должна содержать строку \"PATCH\"? Ответ: $a, $b или $c.", a:"$c"});
		UserTest.quests.push({q:"Функциональные тесты. $crawler = $client->request($method, $routeName);. Страница содержит форму с инпутами типа текст, первый содержит значение. Как получить это значение в переменную $s? ($s = ...;)", a:"$s = $crawler->filter(\"input[type=text]\")->first()->attr(\"value\");"});
		UserTest.quests.push({q:"Переводы. В какой секции файла config.yml содержится default_locale?", a:"framework"});
		UserTest.quests.push({q:"Переводы. Укажите путь к yml файлу переводов сообщений для пакета AcmeHelloBundle от каталога src, локаль ru? (src/**.yml)", a:"src/Acme/HelloBundleResources/translations/messages.ru.yml"});
		UserTest.quests.push({q:"Вы хотите импортировать настройки из файла parameters.yml бандла AcmeHelloBundle. Введите имя секции в файле /app/config/parameters.yml и соответствующую строку. (имя секции, строка импорта)", a:"imports, - { resource: @AcmeHelloBundle/Resources/config/parameters.yml } "});
		UserTest.quests.push({q:"В вашем файле parameters.yml задана конфигурация: box1: { subbox1_1: { key1: value32 } }. Как получить значение key1 в контроллере? ($this->...;)", a: "$this->container->getParameter('box1')['subbox1_1']['key1'];"});
		UserTest.quests.push({q:"Вы хотите использовать SwiftMailer для отправки письма в коде контроллера. Введите инструкцию use подключающую необходимый пакет.", a: "use Symfony\\Bundle\\Swiftmailerbundle\\SwiftmailerBundle;"});
		UserTest.quests.push({q:"Как в контроллере получить объект для формирования email сообщения (используя swiftmailer)? ($message = ...;)", a: "$message = Swift_Message::newInstance();"});
		UserTest.quests.push({q:"$message = Swift_Message::newInstance(); Перечислите методы объекта message (без аргументов и круглых скобок), позволяющие задать тему письма, текст письма, адрес отправителя, адрес получателя.", a: "setSubject, setBody, setFrom, setTo"});
		UserTest.quests.push({q:"В строке $s у вас содержится html код сообщения. Введите вызов метода $message->setBody позволяющий отправить вам сообщение в формате html  и кодировке UTF-8", a: "$message->setBody($s, \"text/html\", \"UTF-8\");"});
		UserTest.quests.push({q:"Введите строку php кода, позволяющий отправить вам сообщение $message из контроллера.", a: "$this->get(\"mailer\")->send($message);"});
		UserTest.quests.push({q:"Введите одной строкой yml конфигурацию swiftmailer, если ваш ящик user_admin@gmail.com, а пароль 123456.", a: "swiftmailer: { transport: gmail, username: user_admin@gmail.com, password: 123456 }"});
		UserTest.quests.push({q:"Связывание в Doctrine. На вашем сайте пользователи могут добавлять комментарии. Введите аннотацию \"Один ко многим\" для члена класса CUser comments, если автор комментария доступен в классе Acme\\HelloBundle\\Entity\\Comment через член user.", a: "@ORM\\OneToMany(targetEntity=\"Acme\\HelloBundle\\Entity\\Comment\", mappedBy=\"user\")"});
		//timestamp в doctrine
		

		//UserTest.randomize = true; //вопросы будут выводится случайным образом
		/** @desc Объект реализующий интерфейс представления данных теста, через него тест взаимодействует с DOM */
			UserTest.view = {
			setScore:function(v){
				$("#ut_main_tscore").text(v);
			},
			setTime: function(v){
				$("#ut_main_ttime_left").text(v);
			},
			clearPrevStatus: function() {
				$('#utMainTTPlayscreen').removeClass('hide');
				$('#utMainTTDonescreen').addClass('hide');
				$('#utMainTTFailscreen').addClass('hide');
			},
			setQuest: function(v, answers, rule) {
				if (v == '') {
					v = '&nbsp;';
				}
				$('#ut_main_tanswer').val('');
				if ( $('#ut_main_tanswer')[0] ) {
					$('#ut_main_tanswer')[0].focus();
				}
				$("#ut_main_tquest").text(v);
				cover();
				if (String(rule) == "undefined") {
					return;
				}
			},
			setBeginScreen: function(v){
				cover();
				$('#utMainTTFailscreen').addClass('hide');
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTHelloScreen').removeClass('hide');
				$("#ut_main_tstartGame").prop('disabled', false);
				UserTest.state = 0;
			},
			setGameScreen: function(){
				$("#ut_main_tstartGame").prop('disabled', true);
				this.beginScreenSets = false;
				cover();
			},
			setLives: function(v) {
				$("#ut_main_tlives").text(v);
			},
			setDoneOneAnswerScreen: function(){
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTDonescreen').removeClass('hide');
				if (!$('#ut_main_tSuccessInfo').hasClass('hide')) {
					$('#ut_main_tSuccessInfo').addClass('hide');
				}
				$('#ut_main_tSuccess').html('Правильно!');
				cover();
				return 1;
			},
			setFailOneAnswerScreen: function(answer){
				$('#ut_main_tErr').text('Ошибка!');
				$('#ut_main_tRa').text(answer);
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTFailscreen').removeClass('hide');
				cover();
				return 7;
			},
			setGameOverScreen: function(){
				$('#ut_main_tErr').text('GAME OVER');
				if ( !this.beginScreenSets ) {
					this.beginScreenSets = true;
					var o = this;
					setTimeout(
						function () {
							o.setBeginScreen();
						},
						5000
					);
				}
			},
			getAnswer: function(){
				return $('#ut_main_tanswer').val();
			},
			setWinScreen: function(){
				this.clearPrevStatus();
				var s = 'Очень хорошо!';
				if (UserTest.lives == 1) {
					s = 'Хорошо!';
				}
				$('#ut_main_tSuccess').html(s);
				$('#ut_main_tSuccessInfo').removeClass('hide');
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTDonescreen').removeClass('hide');
				cover();
				var o = this;
				UserTest.state = 0;
				setTimeout(
					function () {
						o.setBeginScreen();
					},
					5000
				);
			},
			setSkipButtonState: function(is_enabled) {
				$('#ut_main_tSkip').prop('disabled', !is_enabled);
			}
		};
		
		UserTest.init();		//Запуск
		var C = UserTest.C;		//для более быстрого доступа
		$("#ut_main_tstartGame").prop('disabled', false); //кнопку "Начать тест" сделаем пока ннедоступной
		
		
		/** @desc Взаимодействие пользователя с тестом*/
		$('#ut_main_tstartGame').click( function() {
			$("#utMainTTPlayscreen").removeClass('hide');
			$("#utMainTTHelloScreen").addClass('hide');
			UserTest.state = C.START_GAME;
			UserTest.tick();
		});
		$('#ut_main_tOK').click( function() {
			UserTest.state = C.CHECK_ONE_RESULT;
			UserTest.tick();
			UserTest.tick();
		});
		$('#ut_main_tSkip').click( function() {
			UserTest.state = C.SKIP_ONE_QUEST;
			UserTest.tick();
		});
	}
})()

