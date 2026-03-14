import sys
import os
from google import genai
from google.genai import types

# 1. Get the inputs passed from PHP
# sys.argv[1] will be the task (e.g., 'assignment')
# sys.argv[2] will be the prompt text
if len(sys.argv) < 3:
    print("Error: Missing arguments")
    sys.exit(1)

task = sys.argv[1]
prompt = sys.argv[2]

# 2. Read the API key (assuming the file is in the same folder)
script_dir = os.path.dirname(os.path.abspath(__file__))
key_path = os.path.join(script_dir, "API_KEY")

try:
    with open(key_path, "r") as file:
        my_api_key = file.read().strip()
except FileNotFoundError:
    print("Error: API_KEY file not found.")
    sys.exit(1)

client = genai.Client(api_key=my_api_key)

# 3. Define instructions
if task == "outline":
    system_instruction = "Ти — досвідчений методист. Створи структуру курсу на 4 тижні на основі наданої теми. Відповідай українською мовою."
elif task == "quiz":
    system_instruction = "Створи 3 тестові питання. Ти ПОВИНЕН вивести їх ТІЛЬКИ у форматі Moodle GIFT українською мовою. Без Markdown."
elif task == "assignment":
    system_instruction = "Створи детальне практичне завдання на основі запиту з критеріями оцінювання. Відповідай українською мовою."
else:
    print("Error: Unknown task")
    sys.exit(1)

# 4. Call Gemini and PRINT the result (PHP will capture whatever is printed)
try:
    response = client.models.generate_content(
        model='gemini-2.5-flash',
        contents=prompt,
        config=types.GenerateContentConfig(
            system_instruction=system_instruction,
            temperature=0.2 if task == "quiz" else 0.7 
        )
    )
    # The print statement is how we send data back to PHP!
    print(response.text) 
except Exception as e:
    print(f"Error calling AI: {e}")