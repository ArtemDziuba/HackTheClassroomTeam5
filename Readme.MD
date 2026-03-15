# Плагін ai_assistant

Плагін **ai_assistant**, встановлюється у Moodle.

Плагін складається з двох частин. Скопіюйте їх у відповідні папки вашого Moodle:

| Частина | Куди розмістити |
|---|---|
| Блок (UI) | `moodle/blocks/ai_assistant/` |
| Серверна частина | `moodle/local/ai_assistant/` |

Після копіювання файлів запустіть оновлення Moodle:

```bash
# Через браузер
https://your-moodle-url/admin/index.php

# Або через CLI
php admin/cli/upgrade.php
```

## Вимоги для встановлення плагіну в наявний Moodle

- Moodle 4.4+
- PHP 8.1+
