// Wait for the page to load before doing anything
document.addEventListener("DOMContentLoaded", () => {

  // Get the current host name
  const currentHost = window.location.hostname;

  // Select all anchor tags
  const links = document.querySelectorAll("a");

  links.forEach(link => {
    // Check if the link is external
    if (link.hostname && link.hostname !== currentHost) {
      // Set the target attribute to open in a new window
      link.setAttribute("target", "_blank");

      // Optionally, set rel="noopener noreferrer" for security
      link.setAttribute("rel", "noopener noreferrer");
    }
  });
});