import os
import re

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            # 1. Remove the Sekretaris Desa block that we added
            sekdes_block = r"""\s*@if\(session\('role'\) === 'Sekretaris Desa'\)\s*<p class="menu-title" style="margin-top: 1.5rem;">Manajemen Internal</p>\s*<li class="\{\{ request\(\)->is\('admin/perangkat\*'\) \? 'active' : '' \}\}">.*?</li>\s*@endif"""
            content = re.sub(sekdes_block, '', content)

            # 2. Add back the menu item inside Super Admin
            content = re.sub(r'\s*<li[^>]*><a href="/admin/perangkat".*?</li>', '', content)
            
            potensi_link = r'(<li><a href="/admin/potensi"><i class="fa-solid fa-seedling"></i> Potensi Desa</a></li>)'
            replacement = r'\1\n                <li class="{{ request()->is(\'admin/perangkat*\') ? \'active\' : \'\' }}"><a href="/admin/perangkat"><i class="fa-solid fa-sitemap"></i> Struktur Organisasi</a></li>'
            
            content = re.sub(potensi_link, replacement, content)

            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)

print("Sidebars reverted successfully.")
