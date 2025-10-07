// Basic admin JS (sidebar toggle, flash fadeout)
(() => {
  const sidebar = document.getElementById('adminSidebar');
  const toggle = document.getElementById('sidebarToggle');
  if(toggle && sidebar){
    toggle.addEventListener('click', ()=> sidebar.classList.toggle('open'));
  }
  // Auto fade alerts
  setTimeout(()=>{
    document.querySelectorAll('.alert').forEach(a=>{
      a.style.transition='opacity .6s';
      a.style.opacity='0';
      setTimeout(()=>a.remove(), 800);
    });
  }, 4000);
})();
