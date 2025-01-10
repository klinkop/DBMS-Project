"use strict";
(function() {
  var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

  if (isWindows) {
    // if we are on windows OS we activate the perfectScrollbar function
    if (document.getElementsByClassName('main-content')[0]) {
      var mainpanel = document.querySelector('.main-content');
      var ps = new PerfectScrollbar(mainpanel);
    };

    if (document.getElementsByClassName('sidenav')[0]) {
      var sidebar = document.querySelector('.sidenav');
      var ps1 = new PerfectScrollbar(sidebar);
    };

    if (document.getElementsByClassName('navbar-collapse')[0]) {
      var fixedplugin = document.querySelector('.navbar-collapse');
      var ps2 = new PerfectScrollbar(fixedplugin);
    };

    if (document.getElementsByClassName('fixed-plugin')[0]) {
      var fixedplugin = document.querySelector('.fixed-plugin');
      var ps3 = new PerfectScrollbar(fixedplugin);
    };
  };
})();

// Verify navbar blur on scroll
if (document.getElementById('navbarBlur')) {
  navbarBlurOnScroll('navbarBlur');
}

// initialization of Tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

// when input is focused add focused class for style
function focused(el) {
  if (el.parentElement.classList.contains('input-group')) {
    el.parentElement.classList.add('focused');
  }
}

// when input is focused remove focused class for style
function defocused(el) {
  if (el.parentElement.classList.contains('input-group')) {
    el.parentElement.classList.remove('focused');
  }
}

// helper for adding on all elements multiple attributes
function setAttributes(el, options) {
  Object.keys(options).forEach(function(attr) {
    el.setAttribute(attr, options[attr]);
  })
}

// adding on inputs attributes for calling the focused and defocused functions
if (document.querySelectorAll('.input-group').length != 0) {
  var allInputs = document.querySelectorAll('input.form-control');
  allInputs.forEach(el => setAttributes(el, {
    "onfocus": "focused(this)",
    "onfocusout": "defocused(this)"
  }));
}


// Fixed Plugin

if (document.querySelector('.fixed-plugin')) {
  var fixedPlugin = document.querySelector('.fixed-plugin');
  var fixedPlugin = document.querySelector('.fixed-plugin');
  var fixedPluginButton = document.querySelector('.fixed-plugin-button');
  var fixedPluginButtonNav = document.querySelector('.fixed-plugin-button-nav');
  var fixedPluginCard = document.querySelector('.fixed-plugin .card');
  var fixedPluginCloseButton = document.querySelectorAll('.fixed-plugin-close-button');
  var navbar = document.getElementById('navbarBlur');
  var buttonNavbarFixed = document.getElementById('navbarFixed');

  if (fixedPluginButton) {
    fixedPluginButton.onclick = function() {
      if (!fixedPlugin.classList.contains('show')) {
        fixedPlugin.classList.add('show');
      } else {
        fixedPlugin.classList.remove('show');
      }
    }
  }

  if (fixedPluginButtonNav) {
    fixedPluginButtonNav.onclick = function() {
      if (!fixedPlugin.classList.contains('show')) {
        fixedPlugin.classList.add('show');
      } else {
        fixedPlugin.classList.remove('show');
      }
    }
  }

  fixedPluginCloseButton.forEach(function(el) {
    el.onclick = function() {
      fixedPlugin.classList.remove('show');
    }
  })

  document.querySelector('body').onclick = function(e) {
    if (e.target != fixedPluginButton && e.target != fixedPluginButtonNav && e.target.closest('.fixed-plugin .card') != fixedPluginCard) {
      fixedPlugin.classList.remove('show');
    }
  }

  if (navbar) {
    if (navbar.getAttribute('data-scroll') == 'true' && buttonNavbarFixed) {
      buttonNavbarFixed.setAttribute("checked", "true");
    }
  }

}

// Apply Sidebar Color Immediately
(function applyInstantSidebarColor() {
    var parent = document.querySelector(".nav-link.active");
    var savedColor = localStorage.getItem("sidebarColor");

    if (parent && savedColor) {
      // Remove any existing gradient classes
      parent.classList.remove(
        "bg-gradient-primary",
        "bg-gradient-dark",
        "bg-gradient-info",
        "bg-gradient-success",
        "bg-gradient-warning",
        "bg-gradient-danger"
      );

      // Add the saved gradient class
      parent.classList.add("bg-gradient-" + savedColor);
    }
  })();

  // Set Sidebar Color
  function sidebarColor(a) {
    var parent = document.querySelector(".nav-link.active");
    var color = a.getAttribute("data-color");

    // Remove any existing gradient classes
    parent.classList.remove(
      "bg-gradient-primary",
      "bg-gradient-dark",
      "bg-gradient-info",
      "bg-gradient-success",
      "bg-gradient-warning",
      "bg-gradient-danger"
    );

    // Add the selected gradient class
    parent.classList.add("bg-gradient-" + color);

    // Save the selected color to localStorage
    localStorage.setItem("sidebarColor", color);
  }

  // Apply Sidebar Color on Page Load
  function applySidebarColor() {
    // This will already be handled by the immediate function above
  }

  // Call the function on page load for safety (in case of dynamic content)
  document.addEventListener("DOMContentLoaded", applySidebarColor);



function sidebarType(a) {
    var parent = a.parentElement.children;
    var color = a.getAttribute("data-class");
    var body = document.querySelector("body");
    var bodyWhite = !body.classList.contains('dark-version');
    var bodyDark = body.classList.contains('dark-version');

    var colors = [];

    // Reset all siblings' active class
    for (var i = 0; i < parent.length; i++) {
        parent[i].classList.remove('active');
        colors.push(parent[i].getAttribute('data-class'));
    }

    // Toggle active class for the clicked element
    if (!a.classList.contains('active')) {
        a.classList.add('active');
    } else {
        a.classList.remove('active');
    }

    var sidebar = document.querySelector('.sidenav');

    // Remove any previous sidebar color classes and dark-related classes
    for (var i = 0; i < colors.length; i++) {
        sidebar.classList.remove(colors[i]);
    }

    // Remove dark mode classes
    sidebar.classList.remove('bg-gradient-dark', 'text-dark');
    sidebar.classList.add(color); // Add the new color class

    // Update text color based on sidebar type
    if (color == 'bg-transparent' || color == 'bg-white') {
        var textWhites = document.querySelectorAll('.sidenav .text-white');
        for (let i = 0; i < textWhites.length; i++) {
            textWhites[i].classList.remove('text-white');
            textWhites[i].classList.add('text-dark');
        }
    } else {
        var textDarks = document.querySelectorAll('.sidenav .text-dark');
        for (let i = 0; i < textDarks.length; i++) {
            textDarks[i].classList.add('text-white');
            textDarks[i].classList.remove('text-dark');
        }
    }

    if (color == 'bg-transparent' && bodyDark) {
        var textDarks = document.querySelectorAll('.navbar-brand .text-dark');
        for (let i = 0; i < textDarks.length; i++) {
            textDarks[i].classList.add('text-white');
            textDarks[i].classList.remove('text-dark');
        }
    }

    // Update logo based on sidebar type
    var navbarBrand = document.querySelector('.navbar-brand-img');
    var navbarBrandImg = navbarBrand.src;

    if ((color == 'bg-transparent' || color == 'bg-white') && bodyWhite) {
        if (navbarBrandImg.includes('logo-ct.png')) {
            var navbarBrandImgNew = navbarBrandImg.replace("logo-ct", "logo-ct-dark");
            navbarBrand.src = navbarBrandImgNew;
        }
    } else {
        if (navbarBrandImg.includes('logo-ct-dark.png')) {
            var navbarBrandImgNew = navbarBrandImg.replace("logo-ct-dark", "logo-ct");
            navbarBrand.src = navbarBrandImgNew;
        }
    }

    if (color == 'bg-white' && bodyDark) {
        if (navbarBrandImg.includes('logo-ct.png')) {
            var navbarBrandImgNew = navbarBrandImg.replace("logo-ct", "logo-ct-dark");
            navbarBrand.src = navbarBrandImgNew;
        }
    }

    // Save selected sidebar type to localStorage
    localStorage.setItem('sidebarType', color);
}

// Apply saved Sidebar Type on Page Load
function applySidebarType() {
    const savedSidebarType = localStorage.getItem('sidebarType');
    const sidebar = document.querySelector('.sidenav');
    const buttons = document.querySelectorAll('[data-class]');

    if (savedSidebarType) {
        // Remove all sidebar color classes and dark-related classes before applying
        sidebar.classList.remove('text-dark', 'bg-gradient-dark');
        sidebar.classList.add(savedSidebarType);

        // Update button active state
        buttons.forEach(button => {
            if (button.getAttribute('data-class') === savedSidebarType) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });

        // Update text and logo based on the saved type
        if (savedSidebarType == 'bg-transparent' || savedSidebarType == 'bg-white') {
            var textWhites = document.querySelectorAll('.sidenav .text-white');
            for (let i = 0; i < textWhites.length; i++) {
                textWhites[i].classList.remove('text-white');
                textWhites[i].classList.add('text-dark');
            }
        } else {
            var textDarks = document.querySelectorAll('.sidenav .text-dark');
            for (let i = 0; i < textDarks.length; i++) {
                textDarks[i].classList.add('text-white');
                textDarks[i].classList.remove('text-dark');
            }
        }
    }
}

// Call the function on page load
document.addEventListener("DOMContentLoaded", function() {
    applySidebarType();
});


// Set Navbar Fixed
function navbarFixed(el) {
  let classes = [
    "position-sticky",
    "blur",
    "shadow-blur",
    "mt-4",
    "left-auto",
    "top-1",
    "z-index-sticky",
  ];
  const navbar = document.getElementById("navbarBlur");

  if (!el.getAttribute("checked")) {
    navbar.classList.add(...classes);
    navbar.setAttribute("navbar-scroll", "true");
    navbarBlurOnScroll("navbarBlur");
    el.setAttribute("checked", "true");

    // Save state to localStorage
    localStorage.setItem("navbarFixed", "true");
  } else {
    navbar.classList.remove(...classes);
    navbar.setAttribute("navbar-scroll", "false");
    navbarBlurOnScroll("navbarBlur");
    el.removeAttribute("checked");

    // Remove state from localStorage
    localStorage.setItem("navbarFixed", "false");
  }
}

// Apply Navbar Fixed State on Page Load
function applyNavbarFixed() {
  let classes = [
    "position-sticky",
    "blur",
    "shadow-blur",
    "mt-4",
    "left-auto",
    "top-1",
    "z-index-sticky",
  ];
  const navbar = document.getElementById("navbarBlur");
  const navbarState = localStorage.getItem("navbarFixed");
  const toggleButton = document.querySelector("[data-navbar-toggle]");

  if (navbarState === "true") {
    navbar.classList.add(...classes);
    navbar.setAttribute("navbar-scroll", "true");
    navbarBlurOnScroll("navbarBlur");

    // Set toggle button checked state
    if (toggleButton) {
      toggleButton.setAttribute("checked", "true");
    }
  } else {
    navbar.classList.remove(...classes);
    navbar.setAttribute("navbar-scroll", "false");
    navbarBlurOnScroll("navbarBlur");

    // Reset toggle button checked state
    if (toggleButton) {
      toggleButton.removeAttribute("checked");
    }
  }
}

// Call the function on page load
document.addEventListener("DOMContentLoaded", applyNavbarFixed);



// Set Navbar Minimized
function navbarMinimize(el) {
  var sidenavShow = document.getElementsByClassName('g-sidenav-show')[0];

  if (!el.getAttribute("checked")) {
    sidenavShow.classList.remove('g-sidenav-pinned');
    sidenavShow.classList.add('g-sidenav-hidden');
    el.setAttribute("checked", "true");
  } else {
    sidenavShow.classList.remove('g-sidenav-hidden');
    sidenavShow.classList.add('g-sidenav-pinned');
    el.removeAttribute("checked");
  }
}

// Navbar blur on scroll
function navbarBlurOnScroll(id) {
  const navbar = document.getElementById(id);
  let navbarScrollActive = navbar ? navbar.getAttribute("data-scroll") : false;
  let scrollDistance = 5;
  let classes = ['blur', 'shadow-blur', 'left-auto'];
  let toggleClasses = ['shadow-none'];

  if (navbarScrollActive == 'true') {
    window.onscroll = debounce(function() {
      if (window.scrollY > scrollDistance) {
        blurNavbar();
      } else {
        transparentNavbar();
      }
    }, 10);
  } else {
    window.onscroll = debounce(function() {
      transparentNavbar();
    }, 10);
  }

  var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

  if (isWindows) {
    var content = document.querySelector('.main-content');
    if (navbarScrollActive == 'true') {
      content.addEventListener('ps-scroll-y', debounce(function() {
        if (content.scrollTop > scrollDistance) {
          blurNavbar();
        } else {
          transparentNavbar();
        }
      }, 10));
    } else {
      content.addEventListener('ps-scroll-y', debounce(function() {
        transparentNavbar();
      }, 10));
    }
  }

  function blurNavbar() {
    navbar.classList.add(...classes)
    navbar.classList.remove(...toggleClasses)

    toggleNavLinksColor('blur');
  }

  function transparentNavbar() {
    navbar.classList.remove(...classes)
    navbar.classList.add(...toggleClasses)

    toggleNavLinksColor('transparent');
  }

  function toggleNavLinksColor(type) {
    let navLinks = document.querySelectorAll('.navbar-main .nav-link')
    let navLinksToggler = document.querySelectorAll('.navbar-main .sidenav-toggler-line')

    if (type === "blur") {
      navLinks.forEach(element => {
        element.classList.remove('text-body')
      });

      navLinksToggler.forEach(element => {
        element.classList.add('bg-dark')
      });
    } else if (type === "transparent") {
      navLinks.forEach(element => {
        element.classList.add('text-body')
      });

      navLinksToggler.forEach(element => {
        element.classList.remove('bg-dark')
      });
    }
  }
}

// Debounce Function
// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this,
      args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
};

// initialization of Toasts
document.addEventListener("DOMContentLoaded", function() {
  var toastElList = [].slice.call(document.querySelectorAll(".toast"));

  var toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl);
  });

  var toastButtonList = [].slice.call(document.querySelectorAll(".toast-btn"));

  toastButtonList.map(function(toastButtonEl) {
    toastButtonEl.addEventListener("click", function() {
      var toastToTrigger = document.getElementById(toastButtonEl.dataset.target);

      if (toastToTrigger) {
        var toast = bootstrap.Toast.getInstance(toastToTrigger);
        toast.show();
      }
    });
  });
});

// Tabs navigation

var total = document.querySelectorAll('.nav-pills');

function initNavs() {
  total.forEach(function(item, i) {
    var moving_div = document.createElement('div');
    var first_li = item.querySelector('li:first-child .nav-link');
    var tab = first_li.cloneNode();
    tab.innerHTML = "-";

    moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
    moving_div.appendChild(tab);
    item.appendChild(moving_div);

    var list_length = item.getElementsByTagName("li").length;

    moving_div.style.padding = '0px';
    moving_div.style.width = item.querySelector('li:nth-child(1)').offsetWidth + 'px';
    moving_div.style.transform = 'translate3d(0px, 0px, 0px)';
    moving_div.style.transition = '.5s ease';

    item.onmouseover = function(event) {
      let target = getEventTarget(event);
      let li = target.closest('li'); // get reference
      if (li) {
        let nodes = Array.from(li.closest('ul').children); // get array
        let index = nodes.indexOf(li) + 1;
        item.querySelector('li:nth-child(' + index + ') .nav-link').onclick = function() {
          moving_div = item.querySelector('.moving-tab');
          let sum = 0;
          if (item.classList.contains('flex-column')) {
            for (var j = 1; j <= nodes.indexOf(li); j++) {
              sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
            }
            moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
            moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
          } else {
            for (var j = 1; j <= nodes.indexOf(li); j++) {
              sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
            }
            moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
            moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
          }
        }
      }
    }
  });
}

setTimeout(function() {
  initNavs();
}, 100);

// Tabs navigation resize

window.addEventListener('resize', function(event) {
  total.forEach(function(item, i) {
    item.querySelector('.moving-tab').remove();
    var moving_div = document.createElement('div');
    var tab = item.querySelector(".nav-link.active").cloneNode();
    tab.innerHTML = "-";

    moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
    moving_div.appendChild(tab);

    item.appendChild(moving_div);

    moving_div.style.padding = '0px';
    moving_div.style.transition = '.5s ease';

    let li = item.querySelector(".nav-link.active").parentElement;

    if (li) {
      let nodes = Array.from(li.closest('ul').children); // get array
      let index = nodes.indexOf(li) + 1;

      let sum = 0;
      if (item.classList.contains('flex-column')) {
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
        }
        moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
        moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
        moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
      } else {
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
        }
        moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
        moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';

      }
    }
  });

  if (window.innerWidth < 991) {
    total.forEach(function(item, i) {
      if (!item.classList.contains('flex-column')) {
        item.classList.remove('flex-row');
        item.classList.add('flex-column', 'on-resize');
        let li = item.querySelector(".nav-link.active").parentElement;
        let nodes = Array.from(li.closest('ul').children); // get array
        let index = nodes.indexOf(li) + 1;
        let sum = 0;
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
        }
        var moving_div = document.querySelector('.moving-tab');
        moving_div.style.width = item.querySelector('li:nth-child(1)').offsetWidth + 'px';
        moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';

      }
    });
  } else {
    total.forEach(function(item, i) {
      if (item.classList.contains('on-resize')) {
        item.classList.remove('flex-column', 'on-resize');
        item.classList.add('flex-row');
        let li = item.querySelector(".nav-link.active").parentElement;
        let nodes = Array.from(li.closest('ul').children); // get array
        let index = nodes.indexOf(li) + 1;
        let sum = 0;
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
        }
        var moving_div = document.querySelector('.moving-tab');
        moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
        moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
      }
    })
  }
});

// Function to remove flex row on mobile devices
if (window.innerWidth < 991) {
  total.forEach(function(item, i) {
    if (item.classList.contains('flex-row')) {
      item.classList.remove('flex-row');
      item.classList.add('flex-column', 'on-resize');
    }
  });
}

function getEventTarget(e) {
  e = e || window.event;
  return e.target || e.srcElement;
}

// End tabs navigation

window.onload = function() {
  // Material Design Input function
  var inputs = document.querySelectorAll('input');

  for (var i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('focus', function(e) {
      this.parentElement.classList.add('is-focused');
    }, false);

    inputs[i].onkeyup = function(e) {
      if (this.value != "") {
        this.parentElement.classList.add('is-filled');
      } else {
        this.parentElement.classList.remove('is-filled');
      }
    };

    inputs[i].addEventListener('focusout', function(e) {
      if (this.value != "") {
        this.parentElement.classList.add('is-filled');
      }
      this.parentElement.classList.remove('is-focused');
    }, false);
  }

  // Ripple Effect
  var ripples = document.querySelectorAll('.btn');

  for (var i = 0; i < ripples.length; i++) {
    ripples[i].addEventListener('click', function(e) {
      var targetEl = e.target;
      var rippleDiv = targetEl.querySelector('.ripple');

      rippleDiv = document.createElement('span');
      rippleDiv.classList.add('ripple');
      rippleDiv.style.width = rippleDiv.style.height = Math.max(targetEl.offsetWidth, targetEl.offsetHeight) + 'px';
      targetEl.appendChild(rippleDiv);

      rippleDiv.style.left = (e.offsetX - rippleDiv.offsetWidth / 2) + 'px';
      rippleDiv.style.top = (e.offsetY - rippleDiv.offsetHeight / 2) + 'px';
      rippleDiv.classList.add('ripple');
      setTimeout(function() {
        rippleDiv.parentElement.removeChild(rippleDiv);
      }, 600);
    }, false);
  }
};

// Toggle Sidenav
const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
const iconSidenav = document.getElementById('iconSidenav');
const sidenav = document.getElementById('sidenav-main');
let body = document.getElementsByTagName('body')[0];
let className = 'g-sidenav-pinned';

if (iconNavbarSidenav) {
  iconNavbarSidenav.addEventListener("click", toggleSidenav);
}

if (iconSidenav) {
  iconSidenav.addEventListener("click", toggleSidenav);
}

function toggleSidenav() {
  if (body.classList.contains(className)) {
    body.classList.remove(className);
    setTimeout(function() {
      sidenav.classList.remove('bg-white');
    }, 100);
    sidenav.classList.remove('bg-transparent');

  } else {
    body.classList.add(className);
    sidenav.classList.add('bg-white');
    sidenav.classList.remove('bg-transparent');
    iconSidenav.classList.remove('d-none');
  }
}

// Resize navbar color depends on configurator active type of sidenav

let referenceButtons = document.querySelector('[data-class]');

window.addEventListener("resize", navbarColorOnResize);

function navbarColorOnResize() {
  if (window.innerWidth > 1200) {
    if (referenceButtons.classList.contains('active') && referenceButtons.getAttribute('data-class') === 'bg-transparent') {
      sidenav.classList.remove('bg-white');
    } else {
      sidenav.classList.add('bg-white');
    }
  } else {
    sidenav.classList.add('bg-white');
    sidenav.classList.remove('bg-transparent');
  }
}

// Deactivate sidenav type buttons on resize and small screens
window.addEventListener("resize", sidenavTypeOnResize);
window.addEventListener("load", sidenavTypeOnResize);

function sidenavTypeOnResize() {
  let elements = document.querySelectorAll('[onclick="sidebarType(this)"]');
  if (window.innerWidth < 1200) {
    elements.forEach(function(el) {
      el.classList.add('disabled');
    });
  } else {
    elements.forEach(function(el) {
      el.classList.remove('disabled');
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
    // Check saved mode on page load
    const savedMode = localStorage.getItem("mode");
    const body = document.getElementsByTagName('body')[0];

    if (savedMode === "dark") {
      body.classList.add("dark-version");
      applyDarkMode(true); // Function to apply dark mode styles
    } else {
      body.classList.remove("dark-version");
      applyDarkMode(false); // Function to apply light mode styles
    }
  });

// Light Mode / Dark Mode
function darkMode(el) {
    const body = document.getElementsByTagName('body')[0];
    const isDarkMode = body.classList.contains("dark-version");

    if (!isDarkMode) {
      body.classList.add("dark-version");
      applyDarkMode(true); // Apply dark mode styles
      localStorage.setItem("mode", "dark"); // Save preference
      el.setAttribute("checked", "true");
    } else {
      body.classList.remove("dark-version");
      applyDarkMode(false); // Apply light mode styles
      localStorage.setItem("mode", "light"); // Save preference
      el.removeAttribute("checked");
    }
  }

  function applyDarkMode(isDark) {
    // Apply dark or light mode based on isDark
    const hr = document.querySelectorAll('div:not(.sidenav) > hr');
    const text_btn = document.querySelectorAll('button:not(.btn) > .text-dark');
    const text_span = document.querySelectorAll('span.text-dark, .breadcrumb .text-dark');
    const text_span_white = document.querySelectorAll('span.text-white, .breadcrumb .text-white');
    const card_border = document.querySelectorAll('.card.border');
    const card_border_dark = document.querySelectorAll('.card.border.border-dark');
    const svg = document.querySelectorAll('g');
    const table = document.getElementById('myTable'); // Target your table

    if (isDark) {
      for (let i = 0; i < hr.length; i++) hr[i].classList.replace("dark", "light");
      for (let i = 0; i < text_btn.length; i++) text_btn[i].classList.replace("text-dark", "text-white");
      for (let i = 0; i < text_span.length; i++) text_span[i].classList.replace("text-dark", "text-white");
      for (let i = 0; i < card_border.length; i++) card_border[i].classList.add("border-dark");
      for (let i = 0; i < svg.length; i++) svg[i].setAttribute("fill", "#fff");
      if (table) table.classList.add("dark-table"); // Add dark class to the table
    } else {
      for (let i = 0; i < hr.length; i++) hr[i].classList.replace("light", "dark");
      for (let i = 0; i < text_btn.length; i++) text_btn[i].classList.replace("text-white", "text-dark");
      for (let i = 0; i < text_span_white.length; i++) text_span_white[i].classList.replace("text-white", "text-dark");
      for (let i = 0; i < card_border_dark.length; i++) card_border_dark[i].classList.remove("border-dark");
      for (let i = 0; i < svg.length; i++) svg[i].setAttribute("fill", "#252f40");
      if (table) table.classList.remove("dark-table"); // Remove dark class from the table
    }
  }
