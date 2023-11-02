function updateDateTime() {
  const breadcrumbItem = document.querySelector('.breadcrumb-item.active');
  if (breadcrumbItem) {
      const now = new Date();
      const timeAndDate = `Date: ${now.toLocaleDateString()}<br>Time: ${now.toLocaleTimeString()}`;
      breadcrumbItem.innerHTML = timeAndDate;
  }
}

setInterval(updateDateTime, 1000); 