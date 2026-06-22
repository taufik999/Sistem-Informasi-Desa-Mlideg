import os
import re

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            new_content = re.sub(r'<li><a href="#"><i class="fa-solid fa-gears"></i> Pengaturan AHP</a></li>', r'<li><a href="/admin/ahp"><i class="fa-solid fa-gears"></i> Pengaturan AHP</a></li>', content)

            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Fixed {filepath}")

print("Fix AHP complete")
