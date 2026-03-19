function logout() {
  var a=confirm("Do you really want to logout ? ");
  if(a){window.location.href = 'signin.html';}
}
function showSection(sectionId) 
{
    const sections = ['profile', 'menu', 'cart', 'order'];
    sections.forEach(id => {
      document.getElementById(id).style.display = id === sectionId ? 'block' : 'none';
    });
}
function showSectionA(sectionId) 
{
    const sections = ['profile', 'menu', 'orders'];
    sections.forEach(id => {
      document.getElementById(id).style.display = id === sectionId ? 'block' : 'none';
    });
}