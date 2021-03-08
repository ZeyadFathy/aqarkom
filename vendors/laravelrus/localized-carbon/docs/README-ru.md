# Localized Carbon

+ [Вступление](#intro)
+ [Использование](#usage)
+ [Поддерживаемые языки](#languages)
+ [Установка](#installation)
+ [Расширение пакета](#extending)
+ [Вклад в развитие пакета](#contributing)

<a name="intro"></a>
## Вступление

`Localized Carbon` - это расширение популярного пакета `Carbon`. Оно предназначено для использования исключительно во фреймворке Laravel. Под локализацией подразумевается локализация функции `diffForHumans` оригинального Carbon'а, предназначенная для вывода удобочитамой разницы в датах.

<a name="usage"></a>
## Использование

Этот пакет предоставляет класс `LocalizedCarbon`, который наследует оригинальный `Carbon`, поэтому его использование ничем не отличается от оригинального Carbon'а.

Но представте, что у вас есть модель `Comment` (комментарий), в которой имеются временные поля по умолчанию (`created_at` и `updated_at`). И вам требуется вывести информацию о том, сколько времени прошло с момента создания комментария (поле `created_at`), в удобочитаемом формате. Это можно сделать несколькими способами, например так (в Blade-шаблоне):

```
{{ LocalizedCarbon::instance($comment->created_at)->diffForHumans() }}
```

В этом случае класс выведет что-то вроде "5 минут назад" для русского языка.

Но есть и другой способ. Вы можете подменить имеющийся в Laravel класс Eloquent\Model при помощи поставляемого с пакетом классаа модели, чтобы временные поля, наподобие `created_at` и т.д., конвертировались в `LocalizedCarbon`, вместо `Carbon`. Таким образом, использование `LocalizedCarbon` ничем не будет отличаться от привычного:

```
{{ $comment->created_at->diffForHumans() }}
```

Как и в исходном Carbon'е, метод `diffForHumans` имеет первый необязательный аргумент (который является другим экземпляром класса `Carbon`). Он указывает время, относительно которого вычислять разницу. По умолчанию (если этот параметр не задан, или равен `null`) используется текущее время.

В методе классе `LocalizedCarbon` имеется и второе необязательный аргумент, в котором вы можете указать желаемый язык, или напрямую класс-форматтер, используемый для формирования строки-разницы между временами (см. [расширение](#extending)). По умолчанию будет использоваться текущий язык приложения. Также, в качестве второго аргумента можно передавать замыкание, которое будет форматировать строку. Параметры этого замыкания аналогичные метода `format` интерфейса `DiffFormatterInterface` (см. раздел [Расширение Localzied Carbon](#extending)).

<a name="languages"></a>
## Поддерживаемые языки

Текущая версия Localized Carbon поставляетс со следующими локализациями:

+ Английский (en)
+ Русский (ru)
+ Украинский (uk)
+ Голландский (nl)
+ Испанский (es)
+ Португальский (pt)
+ Французский (fr)
+ Болгарский (bg)
+ Словацкий (sk)
+ Турецкий (tr)
+ Арабский (ar)

Но пакет расширяем, то есть вы можете написать и использовать свою собственную локализацию, не трогая само содержимое пакета. См. [расширение пакета](#extending).

<a name="installation"><a/>
## Установка

Добавьте следующее определение в секцию `require` файла `composer.json` вашего проекта: `"laravelrus/localized-carbon": "1.*"`, после чего выполните команду `composer update`.

Далее нужно добавить сервис провайдер (Service Provider), поставляемый с пакетом, в раздел `providers` файла `app/config/app.php`:

```
    'Laravelrus\LocalizedCarbon\LocalizedCarbonServiceProvider',
```

После этого рекомендуется добавить следующие алиасы (секция `aliases` того же конфига):

```
        'LocalizedCarbon'   => 'Laravelrus\LocalizedCarbon\LocalizedCarbon',
        'DiffFormatter'     => 'Laravelrus\LocalizedCarbon\DiffFactoryFacade',
```

Стоит отметить, что класс `DiffFormatter` будет использоваться только для расширения пакета дополнительными локализациями. См. [расширение пакета](#extending).

Если вы хотите использовать `LocalizedCarbon` привычным способом в ваших моделях, то можете воспользоваться поставляемым трейтом:

```
use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
```

В этом случае для всех дат в вашей ELoquent-модели будет использоваться `LocalizedCarbon` вместо исходного `Carbon`.

Но этот способ годится только если Вы используете PHP версии 5.4 или выше.

Если же Вы по-прежнему используете PHP версии 5.3.7, вы можете подменить имеющийся в Laravel класс Eloquent поставляемым классом `Laravelrus\LocalizedCarbon\Models\Eloquent`. Для этого вы можете как наследовать свои модели как напрямую от этого класса, так и заменить алиас к Eloquent на него в файле 'app\config\app.php'.

<a name="extending"></a>
## Расширение пакета

Если требуемая локализация не поствляется с пакетом, вы можете написать свою собственную и расширить пакет, не трогая его содержимое.

Существует несеколько способов расширить класс Localized Carbon.

Во-первых, вы можете написать свой класс `DiffFormatter` для этого, который реализует интерфейс `Laravelrus\LocalizedCarbon\DiffFormatters\DiffFormatterInterface`. Этот интерфейс требует от класса реализовать единственный метод `format`, который имеет следующий вид:

```
public function format($isNow, $isFuture, $delta, $unit);
```

+ `$isNow` - это флаг, который равен `true`, если разница во времени вычисляется относительно текущего времени.
+ `$isFuture` - это флаг, который равен `true`, если время находится в будущем относительно проверяемого времени.
+ `$delta` - это число, содержащее разницу во времени в единицах, указанных в `$unit`.
+ `$unit` - это единица измерения параметра `$delta`. Может принимать одно из следующих значений: `second` (секунды), `minute` (минуты), `hour` (часы), `day` (дни), `week` (недели), `month` (месяцы) или `year` (года).

Таким образом, ваш метод `format` должен возвращать строку, сформированную на основе этих аргументов. Для примера смотрите существующие форматтеры в директории `vendor\laravelrus\localized-carbon\src\Laravelrus\LocalizedCarbon\DiffFormatters`. Вы также можете например ссылаться на языковые файлы, посредством `Lang::choice`, как это сделано, например, в русской локализации.

Как только ваш класс будет готов, нужно зарегистрировать его в пакете. Для этого нужно вызвать `DiffFormatter::extend` из любого файла, который подключается фреймворком. Например, это можно сделать где-нибудь в файле `app/start/global.php`.

Метод `extend` принимает два аргумента. Первый - это язык, для которого написан этот форматтер (чаще всего это будет `App::getLocale()`, если вы пишете локализацию для текущего языка приложения). Следующий аргумент - это экземпляр вашего класса, ЛИБО просто полное имя вашего класса, принимая во внимание то, что он должен быть доступен для автозагрузки. Взгляните на примеры:

```
$formatter = new Acme\DiffFormatters\FrDiffFormatter;
DiffFormatter::extend('fr', $formatter);

// ИЛИ

DiffFormatter::extend('fr', 'Acme\\DiffFormatters\\FrDiffFormatter');
```

В последнем случае форматтер будет автоматически загружен, как только в нем будет необходимость (посредством IoC). Имейте также ввиду, что форматтер будет загружен только однажды за весь цикл приложениия из соображений оптимизации.

Второй способ - это передать замыкание в качестве второго аргумента `extend`. Параметры замыкания должны быть такими же, как и у метода `format` интерфейса `DiffFormatterInterface`. Например:

```
DiffFormatter::extend('fr', function($isNow, $isFuture, $delta, $unit) {
    return 'Сформированная строка!';
});
```

Также возможно добавлять "алиасы" к существующим языкам. Например, Localized Carbon поставляется с Украинской локализацией, которая распознается по языковому ключу `uk`. Но что, если в вашем приложении для украинского языка используется ключ `ua`, или `ukr`? В это случае вы можете зарегистрировать алиас для языка `uk` таким образом:

```
DiffFormatter::alias('ukr', 'uk');
```

<a name="contributing"></a>
## Вклад в развитие пакета

Если вы написали локализацию для языка, которые не поставляется с текущей версией пакета, будет здорово, если вы сделаете pull request с ним в текущую ветку пакета (1.3), убедившись только, что вы "настроили" его для использования внутри пакета.

Форматтер должен находиться в директории `src/Laravelrus/LocalizedCarbon/DiffFormatters` и следовать следующим соглашениям: имя класса должно начинаться с языка, для которого он написан, в нижнем регистре, но первый символ - в верхнем. Осальная часть имени должна заканчиваться на `DiffFormatter`. Имя файла должно соответствовать имени класса.

Например, форматтер для языка `fr` (французский) будет находится в файле `src/Laravelrus/LocalizedCarbon/DiffFormatters/FrDiffFormatter.php`, а имя класса будет соответственно `FrDiffFormatter`.