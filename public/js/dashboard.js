/* ── TOGGLE SIDEBAR ── */
const sidebar = document.getElementById('sidebar')
const btnToggle = document.getElementById('toggle-sidebar-btn')
const toggleIcon = document.getElementById('toggle-icon')
let isCollapsed = false

function toggleSidebar() {
    isCollapsed = !isCollapsed
    if (isCollapsed) {
        sidebar.classList.add('collapsed')
        if (toggleIcon) {
            toggleIcon.classList.remove('ti-layout-sidebar')
            toggleIcon.classList.add('ti-layout-sidebar-right')
        }
        // Tutup semua submenu saat collapsed
        document.querySelectorAll('.submenu').forEach(el => {
            el.classList.remove('show')
            el.style.maxHeight = '0'
        })
        document.querySelectorAll('.chev-sub').forEach(el => el.classList.remove('rotated'))
    } else {
        sidebar.classList.remove('collapsed')
        if (toggleIcon) {
            toggleIcon.classList.remove('ti-layout-sidebar-right')
            toggleIcon.classList.add('ti-layout-sidebar')
        }
    }
    localStorage.setItem('sidebarCollapsed', isCollapsed)
}

if (btnToggle) {
    btnToggle.addEventListener('click', function (e) {
        e.preventDefault()
        toggleSidebar()
    })
}

// Pulihkan state dari localStorage
if (localStorage.getItem('sidebarCollapsed') === 'true') {
    toggleSidebar()
}

/* ── ACCORDION SUBMENU ── */
document.querySelectorAll('[data-has-sub]').forEach(item => {
    item.addEventListener('click', (e) => {
        e.stopPropagation()
        // Jangan buka submenu jika sidebar collapsed
        if (isCollapsed) return

        const sub = item.nextElementSibling
        const chev = item.querySelector('.chev-sub')

        // Tutup semua submenu lain
        document.querySelectorAll('.submenu').forEach(el => {
            if (el !== sub) {
                el.classList.remove('show')
                el.style.maxHeight = '0'
            }
        })
        document.querySelectorAll('.chev-sub').forEach(el => {
            if (el !== chev) el.classList.remove('rotated')
        })

        // Toggle submenu yang diklik
        if (sub.classList.contains('show')) {
            sub.classList.remove('show')
            sub.style.maxHeight = '0'
            chev?.classList.remove('rotated')
        } else {
            sub.classList.add('show')
            sub.style.maxHeight = sub.scrollHeight + 'px'
            chev?.classList.add('rotated')
        }
    })
})

/* ── HIGHLIGHT MENU AKTIF ── */
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', () => {
        // Hanya hilangkan active class jika bukan karena submenu
        if (!isCollapsed) {
            document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'))
            item.classList.add('active')
        }
    })
})

/* ── DROPDOWN PROFIL ── */
const btnProfile = document.getElementById('btn-profile')
const dropdown = document.getElementById('profile-dropdown')

if (btnProfile) {
    btnProfile.addEventListener('click', e => {
        e.stopPropagation()
        dropdown.classList.contains('dp-show') ?
            dropdown.classList.replace('dp-show', 'dp-hide') :
            dropdown.classList.replace('dp-hide', 'dp-show')
    })
}

document.addEventListener('click', e => {
    if (dropdown && !e.target.closest('#btn-profile') && !e.target.closest('#profile-dropdown')) {
        dropdown.classList.replace('dp-show', 'dp-hide')
    }
})
