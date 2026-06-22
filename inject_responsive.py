import os
import glob
import re

css_code = """
        /* Sidebar Minimized & Responsive Enhancements */
        .sidebar { transition: all 0.3s ease; z-index: 1000; }
        .sidebar.minimized { width: 80px; }
        .sidebar.minimized .sidebar-brand span, 
        .sidebar.minimized .menu-title, 
        .sidebar.minimized .user-info { display: none; }
        .sidebar.minimized .sidebar-brand { justify-content: center; padding: 1.5rem 0; }
        .sidebar.minimized .sidebar-menu li a { font-size: 0; justify-content: center; padding: 1rem 0; }
        .sidebar.minimized .sidebar-menu li a i { font-size: 1.4rem; width: 100%; text-align: center; margin: 0;}
        .sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }

        .main-content { transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 80px; }

        .btn-toggle-sidebar {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: var(--text-dark); 
            font-size: 1.2rem; cursor: pointer; transition: all 0.3s; margin-right: 1.5rem; 
            width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); flex-shrink: 0;
        }
        .btn-toggle-sidebar:hover { color: var(--primary); border-color: var(--primary); background: #fff7ed; }
        .header-title-wrapper { display: flex; align-items: center; }

        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.6); z-index: 999; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); width: 280px; }
            
            .sidebar.mobile-open .sidebar-menu li a { font-size: 0.95rem; justify-content: flex-start; padding: 0.8rem 1.5rem; }
            .sidebar.mobile-open .sidebar-menu li a i { font-size: 1rem; width: 20px; text-align: center; margin-right: 1rem;}
            .sidebar.mobile-open .sidebar-brand span, 
            .sidebar.mobile-open .menu-title, 
            .sidebar.mobile-open .user-info { display: block; }
            .sidebar.mobile-open .sidebar-brand { justify-content: flex-start; padding: 1.5rem; }
            .sidebar.mobile-open .sidebar-user { justify-content: flex-start; padding: 1.5rem; }
            
            .main-content { margin-left: 0 !important; padding: 1.5rem; }
            .main-content.expanded { margin-left: 0 !important; }
            
            .dash-cards { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: flex-start; gap: 1.2rem; }
            .btn-logout, .btn-add { align-self: flex-start; }
            .news-grid, .gallery-grid { grid-template-columns: 1fr; }
            .upload-section { flex-direction: column; align-items: stretch; gap: 1.5rem; }
            .upload-form { flex-direction: column; }
            .form-row { flex-direction: column; align-items: stretch; }
            .role-alert { flex-direction: column; }
            .table-section { overflow-x: auto; width: 100%; display: block; }
        }
"""

js_code = """
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            
            if(sidebar && !document.querySelector('.sidebar-overlay')){
                const overlay = document.createElement('div');
                overlay.classList.add('sidebar-overlay');
                document.body.appendChild(overlay);

                if(toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.toggle('mobile-open');
                            overlay.classList.toggle('show');
                        } else {
                            sidebar.classList.toggle('minimized');
                            if(mainContent) mainContent.classList.toggle('expanded');
                        }
                    });
                }

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                });

                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('mobile-open');
                        overlay.classList.remove('show');
                    }
                });
            }
        });
    </script>
"""

path = r"c:\Users\User\Documents\KULIAH\TUGAS AKHIR\tugasakhir\resources\views\*.blade.php"
files = glob.glob(path)

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '<aside class="sidebar">' not in content:
        continue

    if 'btn-toggle-sidebar' in content:
        print(f"Skipped {os.path.basename(file)} (already modified)")
        continue
        
    # Inject CSS
    content = content.replace("</style>", css_code + "\n    </style>")
    
    # Inject HTML Toggle Button
    content = re.sub(
        r'(<div class="header">[\s]*?)<div class="header-title">([\s\S]*?)</div>',
        r'\1<div class="header-title-wrapper">\n                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>\n                <div class="header-title">\2</div>\n            </div>',
        content
    )
    
    # Inject JS
    content = content.replace("</body>", js_code + "\n</body>")

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Updated {os.path.basename(file)}")
