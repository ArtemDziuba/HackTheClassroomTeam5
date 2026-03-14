<?php

class block_ai_assistant extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_ai_assistant');
    }

    public function get_content()
    {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $result_html   = '';

        // If the teacher clicked the Generate button
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ai_generate'])) {
            $task   = $_POST['ai_task'];
            $prompt = $_POST['ai_prompt'];

            // Secure the inputs for the command line
            $escaped_task   = escapeshellarg($task);
            $escaped_prompt = escapeshellarg($prompt);

            // Get the absolute path to your Python script
            $python_script = __DIR__ . '/ai_brain.py';

            // Tell PHP to execute Python and grab the text it prints
            // Note: adding 2>&1 captures any Python errors so you can see them if it breaks
            $command   = "python $python_script $escaped_task $escaped_prompt 2>&1";
            $ai_result = shell_exec($command);

            // Format the result to look nice in the block
            $result_html = '<div style="margin-top: 15px; border: 1px solid #ccc; padding: 10px; background: #f9f9f9; white-space: pre-wrap; font-family: monospace;">' . htmlspecialchars($ai_result) . '</div>';
        }

        // The UI Form
        $this->content->text = '
            <div style="padding: 10px;">
                <form method="POST" action="">
                    <select name="ai_task" style="width: 100%; margin-bottom: 10px;">
                        <option value="outline">Структура курсу</option>
                        <option value="quiz">Тестові питання (формат GIFT)</option>
                        <option value="assignment">Завдання та критерії оцінювання</option>
                    </select>
                    <textarea name="ai_prompt" rows="4" style="width: 100%; margin-bottom: 10px;" required placeholder="Напр., Як обробити пропущені числові дані за допомогою медіани..."></textarea>
                    <button type="submit" name="ai_generate" style="width: 100%; padding: 8px; background: #0f6cbf; color: white; border: none; cursor: pointer;">Згенерувати контент</button>
                </form>
                ' . $result_html . '
            </div>
        ';

        return $this->content;
    }
}
