import os
import re

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            # The exact string might vary if it's active or not.
            # Usually it's: <li><a href="/penduduk"><i class="fa-solid fa-users"></i> Data Penduduk</a></li>
            # We want to add: <li><a href="/admin/kk"><i class="fa-solid fa-users-rectangle"></i> Daftar KK</a></li>
            # We will look for <a href="/penduduk">...</a></li> and insert after it.
            
            pattern = r'(<li.*?><a href="/penduduk">.*?</a></li>)'
            
            if re.search(pattern, content):
                # Check if it already has Daftar KK
                if 'href="/admin/kk"' not in content:
                    replacement = r'\1\n            <li><a href="/admin/kk"><i class="fa-solid fa-users-rectangle"></i> Daftar KK</a></li>'
                    new_content = re.sub(pattern, replacement, content)
                    
                    if new_content != content:
                        with open(filepath, 'w', encoding='utf-8') as f:
                            f.write(new_content)
                        print(f"Updated {filepath}")
            
print("Sidebar update script complete.")
