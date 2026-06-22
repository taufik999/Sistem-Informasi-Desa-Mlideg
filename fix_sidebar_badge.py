import os

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Only process if it has sidebar minimized styles and hasn't been fixed yet
            if '.sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }' in content and '.sidebar.minimized .sidebar-menu li a span { display: none; }' not in content:
                replacement = ".sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }\n        .sidebar.minimized .sidebar-menu li a span { display: none; }"
                content = content.replace(".sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }", replacement)
                
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(content)

print("Sidebar badge fix applied to all blade files.")
