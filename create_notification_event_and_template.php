require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

// Проверяем подключение необходимых модулей
if (!CModule::IncludeModule("main")) {
	die("Модуль main не установлен");
}

/**
 * Создание типа почтового события
 */
function createNotificationEventType()
{
	$eventType = new CEventType;
	$eventId = $eventType->Add([
		"LID"           => "s1", 
		"EVENT_NAME"    => "CLIENT_FORM_SUCCESS_NOTIFICATION", // Уникальный код события
		"NAME"          => "Уведомление клиенту об успешной отправке формы",
		"DESCRIPTION"   => "#TEXT# - Сообщение"
	]);

	if ($eventId) {
		echo "Тип почтового события успешно создан (ID: $eventId)<br>";
		return $eventId;
	} else {
		echo "Ошибка при создании типа почтового события <br>";
		return false;
	}
}

/**
 * Создание почтового шаблона
 */
function createNotificationTemplate()
{
	$emailTemplate = new CEventMessage;
	$templateId = $emailTemplate->Add([
		"ACTIVE"        => "Y",
		"EVENT_NAME"    => "CLIENT_FORM_SUCCESS_NOTIFICATION",
		"LID"           => "s1", // ID сайта
		"EMAIL_FROM"    => "#DEFAULT_EMAIL_FROM#",
		"EMAIL_TO"      => "#EMAIL#",
		"SUBJECT"       => "#SITE_NAME# Ваша заявка принята",
		"BODY_TYPE"     => "text",
		"MESSAGE"       => "#TEXT#"
	]);

	if ($templateId) {
		echo "Почтовый шаблон успешно создан (ID: $templateId)<br>";
		return $templateId;
	} else {
		echo "Ошибка при создании почтового шаблона: " . $emailTemplate->LAST_ERROR . "<br>";
		return false;
	}
}



// Выполняем создание
echo "<h3>Создание почтового события и шаблона</h3>";
createNotificationEventType();
createNotificationTemplate();
