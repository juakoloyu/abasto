if (!axs) var axs = {}; if (!goog) var goog = {}; axs.color = {};
axs.color.Color = function(a, b, c, d) {
  this.red = a;
  this.green = b;
  this.blue = c;
  this.alpha = d;
};
axs.color.YCbCr = function(a) {
  this.luma = this.z = a[0];
  this.Cb = this.x = a[1];
  this.Cr = this.y = a[2];
};
axs.color.YCbCr.prototype = {multiply:function(a) {
  return new axs.color.YCbCr([this.luma * a, this.Cb * a, this.Cr * a]);
}, add:function(a) {
  return new axs.color.YCbCr([this.luma + a.luma, this.Cb + a.Cb, this.Cr + a.Cr]);
}, subtract:function(a) {
  return new axs.color.YCbCr([this.luma - a.luma, this.Cb - a.Cb, this.Cr - a.Cr]);
}};
axs.color.calculateContrastRatio = function(a, b) {
  1 > a.alpha && (a = axs.color.flattenColors(a, b));
  a = axs.color.calculateLuminance(a);
  b = axs.color.calculateLuminance(b);
  return (Math.max(a, b) + 0.05) / (Math.min(a, b) + 0.05);
};
axs.color.calculateLuminance = function(a) {
  return axs.color.toYCbCr(a).luma;
};
axs.color.luminanceRatio = function(a, b) {
  return (Math.max(a, b) + 0.05) / (Math.min(a, b) + 0.05);
};
axs.color.parseColor = function(a) {
  if ("transparent" === a) {
    return new axs.color.Color(0, 0, 0, 0);
  }
  var b = a.match(/^rgb\((\d+), (\d+), (\d+)\)$/);
  if (b) {
    a = parseInt(b[1], 10);
    var c = parseInt(b[2], 10), d = parseInt(b[3], 10);
    return new axs.color.Color(a, c, d, 1);
  }
  return (b = a.match(/^rgba\((\d+), (\d+), (\d+), (\d*(\.\d+)?)\)/)) ? (a = parseInt(b[1], 10), c = parseInt(b[2], 10), d = parseInt(b[3], 10), b = parseFloat(b[4]), new axs.color.Color(a, c, d, b)) : null;
};
axs.color.colorChannelToString = function(a) {
  a = Math.round(a);
  return 15 >= a ? "0" + a.toString(16) : a.toString(16);
};
axs.color.colorToString = function(a) {
  return 1 == a.alpha ? "#" + axs.color.colorChannelToString(a.red) + axs.color.colorChannelToString(a.green) + axs.color.colorChannelToString(a.blue) : "rgba(" + [a.red, a.green, a.blue, a.alpha].join() + ")";
};
axs.color.luminanceFromContrastRatio = function(a, b, c) {
  return c ? (a + 0.05) * b - 0.05 : (a + 0.05) / b - 0.05;
};
axs.color.translateColor = function(a, b) {
  var c = b > a.luma ? axs.color.WHITE_YCC : axs.color.BLACK_YCC, d = c == axs.color.WHITE_YCC ? axs.color.YCC_CUBE_FACES_WHITE : axs.color.YCC_CUBE_FACES_BLACK, e = new axs.color.YCbCr([0, a.Cb, a.Cr]), f = new axs.color.YCbCr([1, a.Cb, a.Cr]);
  f = {a:e, b:f};
  e = null;
  for (var g = 0; g < d.length && !(e = axs.color.findIntersection(f, d[g]), 0 <= e.z && 1 >= e.z); g++) {
  }
  if (!e) {
    throw "Couldn't find intersection with YCbCr color cube for Cb=" + a.Cb + ", Cr=" + a.Cr + ".";
  }
  if (e.x != a.x || e.y != a.y) {
    throw "Intersection has wrong Cb/Cr values.";
  }
  if (Math.abs(c.luma - e.luma) < Math.abs(c.luma - b)) {
    return b = [b, a.Cb, a.Cr], axs.color.fromYCbCrArray(b);
  }
  a = (b - e.luma) / (c.luma - e.luma);
  b = [b, e.Cb - e.Cb * a, e.Cr - e.Cr * a];
  return axs.color.fromYCbCrArray(b);
};
axs.color.suggestColors = function(a, b, c) {
  var d = {}, e = axs.color.calculateLuminance(a), f = axs.color.calculateLuminance(b), g = f > e, h = axs.color.toYCbCr(b), k = axs.color.toYCbCr(a), n;
  for (n in c) {
    var l = c[n], m = axs.color.luminanceFromContrastRatio(e, l + 0.02, g);
    if (1 >= m && 0 <= m) {
      var p = axs.color.translateColor(h, m);
      l = axs.color.calculateContrastRatio(p, a);
      m = {};
      m.fg = axs.color.colorToString(p);
      m.bg = axs.color.colorToString(a);
      m.contrast = l.toFixed(2);
      d[n] = m;
    } else {
      l = axs.color.luminanceFromContrastRatio(f, l + 0.02, !g), 1 >= l && 0 <= l && (p = axs.color.translateColor(k, l), l = axs.color.calculateContrastRatio(b, p), m = {}, m.bg = axs.color.colorToString(p), m.fg = axs.color.colorToString(b), m.contrast = l.toFixed(2), d[n] = m);
    }
  }
  return d;
};
axs.color.flattenColors = function(a, b) {
  var c = a.alpha;
  return new axs.color.Color((1 - c) * b.red + c * a.red, (1 - c) * b.green + c * a.green, (1 - c) * b.blue + c * a.blue, a.alpha + b.alpha * (1 - a.alpha));
};
axs.color.multiplyMatrixVector = function(a, b) {
  var c = b[0], d = b[1];
  b = b[2];
  return [a[0][0] * c + a[0][1] * d + a[0][2] * b, a[1][0] * c + a[1][1] * d + a[1][2] * b, a[2][0] * c + a[2][1] * d + a[2][2] * b];
};
axs.color.toYCbCr = function(a) {
  var b = a.red / 255, c = a.green / 255;
  a = a.blue / 255;
  return new axs.color.YCbCr(axs.color.multiplyMatrixVector(axs.color.YCC_MATRIX, [0.03928 >= b ? b / 12.92 : Math.pow((b + 0.055) / 1.055, 2.4), 0.03928 >= c ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4), 0.03928 >= a ? a / 12.92 : Math.pow((a + 0.055) / 1.055, 2.4)]));
};
axs.color.fromYCbCr = function(a) {
  return axs.color.fromYCbCrArray([a.luma, a.Cb, a.Cr]);
};
axs.color.fromYCbCrArray = function(a) {
  var b = axs.color.multiplyMatrixVector(axs.color.INVERTED_YCC_MATRIX, a);
  a = b[0];
  var c = b[1];
  b = b[2];
  return new axs.color.Color(Math.min(Math.max(Math.round(255 * (0.00303949 >= a ? 12.92 * a : 1.055 * Math.pow(a, 1 / 2.4) - 0.055)), 0), 255), Math.min(Math.max(Math.round(255 * (0.00303949 >= c ? 12.92 * c : 1.055 * Math.pow(c, 1 / 2.4) - 0.055)), 0), 255), Math.min(Math.max(Math.round(255 * (0.00303949 >= b ? 12.92 * b : 1.055 * Math.pow(b, 1 / 2.4) - 0.055)), 0), 255), 1);
};
axs.color.RGBToYCbCrMatrix = function(a, b) {
  return [[a, 1 - a - b, b], [-a / (2 - 2 * b), (a + b - 1) / (2 - 2 * b), (1 - b) / (2 - 2 * b)], [(1 - a) / (2 - 2 * a), (a + b - 1) / (2 - 2 * a), -b / (2 - 2 * a)]];
};
axs.color.invert3x3Matrix = function(a) {
  var b = a[0][0], c = a[0][1], d = a[0][2], e = a[1][0], f = a[1][1], g = a[1][2], h = a[2][0], k = a[2][1];
  a = a[2][2];
  return axs.color.scalarMultiplyMatrix([[f * a - g * k, d * k - c * a, c * g - d * f], [g * h - e * a, b * a - d * h, d * e - b * g], [e * k - f * h, h * c - b * k, b * f - c * e]], 1 / (b * (f * a - g * k) - c * (a * e - g * h) + d * (e * k - f * h)));
};
axs.color.findIntersection = function(a, b) {
  var c = [a.a.x - b.p0.x, a.a.y - b.p0.y, a.a.z - b.p0.z];
  b = axs.color.invert3x3Matrix([[a.a.x - a.b.x, b.p1.x - b.p0.x, b.p2.x - b.p0.x], [a.a.y - a.b.y, b.p1.y - b.p0.y, b.p2.y - b.p0.y], [a.a.z - a.b.z, b.p1.z - b.p0.z, b.p2.z - b.p0.z]]);
  c = axs.color.multiplyMatrixVector(b, c)[0];
  return a.a.add(a.b.subtract(a.a).multiply(c));
};
axs.color.scalarMultiplyMatrix = function(a, b) {
  for (var c = [], d = 0; 3 > d; d++) {
    c[d] = axs.color.scalarMultiplyVector(a[d], b);
  }
  return c;
};
axs.color.scalarMultiplyVector = function(a, b) {
  for (var c = [], d = 0; d < a.length; d++) {
    c[d] = a[d] * b;
  }
  return c;
};
axs.color.kR = 0.2126;
axs.color.kB = 0.0722;
axs.color.YCC_MATRIX = axs.color.RGBToYCbCrMatrix(axs.color.kR, axs.color.kB);
axs.color.INVERTED_YCC_MATRIX = axs.color.invert3x3Matrix(axs.color.YCC_MATRIX);
axs.color.BLACK = new axs.color.Color(0, 0, 0, 1.0);
axs.color.BLACK_YCC = axs.color.toYCbCr(axs.color.BLACK);
axs.color.WHITE = new axs.color.Color(255, 255, 255, 1.0);
axs.color.WHITE_YCC = axs.color.toYCbCr(axs.color.WHITE);
axs.color.RED = new axs.color.Color(255, 0, 0, 1.0);
axs.color.RED_YCC = axs.color.toYCbCr(axs.color.RED);
axs.color.GREEN = new axs.color.Color(0, 255, 0, 1.0);
axs.color.GREEN_YCC = axs.color.toYCbCr(axs.color.GREEN);
axs.color.BLUE = new axs.color.Color(0, 0, 255, 1.0);
axs.color.BLUE_YCC = axs.color.toYCbCr(axs.color.BLUE);
axs.color.CYAN = new axs.color.Color(0, 255, 255, 1.0);
axs.color.CYAN_YCC = axs.color.toYCbCr(axs.color.CYAN);
axs.color.MAGENTA = new axs.color.Color(255, 0, 255, 1.0);
axs.color.MAGENTA_YCC = axs.color.toYCbCr(axs.color.MAGENTA);
axs.color.YELLOW = new axs.color.Color(255, 255, 0, 1.0);
axs.color.YELLOW_YCC = axs.color.toYCbCr(axs.color.YELLOW);
axs.color.YCC_CUBE_FACES_BLACK = [{p0:axs.color.BLACK_YCC, p1:axs.color.RED_YCC, p2:axs.color.GREEN_YCC}, {p0:axs.color.BLACK_YCC, p1:axs.color.GREEN_YCC, p2:axs.color.BLUE_YCC}, {p0:axs.color.BLACK_YCC, p1:axs.color.BLUE_YCC, p2:axs.color.RED_YCC}];
axs.color.YCC_CUBE_FACES_WHITE = [{p0:axs.color.WHITE_YCC, p1:axs.color.CYAN_YCC, p2:axs.color.MAGENTA_YCC}, {p0:axs.color.WHITE_YCC, p1:axs.color.MAGENTA_YCC, p2:axs.color.YELLOW_YCC}, {p0:axs.color.WHITE_YCC, p1:axs.color.YELLOW_YCC, p2:axs.color.CYAN_YCC}];
axs.dom = {};
axs.dom.parentElement = function(a) {
  if (!a) {
    return null;
  }
  a = axs.dom.composedParentNode(a);
  if (!a) {
    return null;
  }
  switch(a.nodeType) {
    case Node.ELEMENT_NODE:
      return a;
    default:
      return axs.dom.parentElement(a);
  }
};
axs.dom.shadowHost = function(a) {
  return "host" in a ? a.host : null;
};
axs.dom.composedParentNode = function(a) {
  if (!a) {
    return null;
  }
  if (a.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
    return axs.dom.shadowHost(a);
  }
  var b = a.parentNode;
  if (!b) {
    return null;
  }
  if (b.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
    return axs.dom.shadowHost(b);
  }
  if (!b.shadowRoot) {
    return b;
  }
  a = a.getDestinationInsertionPoints();
  return 0 < a.length ? axs.dom.composedParentNode(a[a.length - 1]) : null;
};
axs.dom.asElement = function(a) {
  switch(a.nodeType) {
    case Node.COMMENT_NODE:
      break;
    case Node.ELEMENT_NODE:
      if ("script" == a.localName || "template" == a.localName) {
        break;
      }
      return a;
    case Node.DOCUMENT_FRAGMENT_NODE:
      return a.host;
    case Node.TEXT_NODE:
      return axs.dom.parentElement(a);
    default:
      console.warn("Unhandled node type: ", a.nodeType);
  }
  return null;
};
axs.dom.composedTreeSearch = function(a, b, c, d) {
  if (a === b) {
    return !0;
  }
  if (a.nodeType == Node.ELEMENT_NODE) {
    var e = a;
  }
  var f = !1;
  if (e && c.preorder && !c.preorder(e)) {
    return f;
  }
  if (e) {
    var g = e.shadowRoot || e.webkitShadowRoot;
    if (g) {
      return f = axs.dom.composedTreeSearch(g, b, c, g), e && c.postorder && !f && c.postorder(e), f;
    }
  }
  if (e && "content" == e.localName) {
    a = e.getDistributedNodes();
    for (g = 0; g < a.length && !f; g++) {
      f = axs.dom.composedTreeSearch(a[g], b, c, d);
    }
    e && c.postorder && !f && c.postorder.call(null, e);
    return f;
  }
  for (a = a.firstChild; null != a && !f;) {
    f = axs.dom.composedTreeSearch(a, b, c, d), a = a.nextSibling;
  }
  e && c.postorder && !f && c.postorder.call(null, e);
  return f;
};
axs.browserUtils = {};
axs.browserUtils.matchSelector = function(a, b) {
  return a.matches ? a.matches(b) : a.webkitMatchesSelector ? a.webkitMatchesSelector(b) : a.mozMatchesSelector ? a.mozMatchesSelector(b) : a.msMatchesSelector ? a.msMatchesSelector(b) : !1;
};
axs.utils = {};
axs.utils.FOCUSABLE_ELEMENTS_SELECTOR = "input:not([type=hidden]):not([disabled]),select:not([disabled]),textarea:not([disabled]),button:not([disabled]),a[href],iframe,[tabindex]";
axs.utils.LABELABLE_ELEMENTS_SELECTOR = "button,input:not([type=hidden]),keygen,meter,output,progress,select,textarea";
axs.utils.elementIsTransparent = function(a) {
  return "0" == a.style.opacity;
};
axs.utils.elementHasZeroArea = function(a) {
  a = a.getBoundingClientRect();
  var b = a.top - a.bottom;
  return a.right - a.left && b ? !1 : !0;
};
axs.utils.elementIsOutsideScrollArea = function(a) {
  for (var b = axs.dom.parentElement(a), c = a.ownerDocument.defaultView; b != c.document.body;) {
    if (axs.utils.isClippedBy(a, b)) {
      return !0;
    }
    if (axs.utils.canScrollTo(a, b) && !axs.utils.elementIsOutsideScrollArea(b)) {
      return !1;
    }
    b = axs.dom.parentElement(b);
  }
  return !axs.utils.canScrollTo(a, c.document.body);
};
axs.utils.canScrollTo = function(a, b) {
  var c = a.getBoundingClientRect(), d = b.getBoundingClientRect();
  if (b == b.ownerDocument.body) {
    var e = d.top, f = d.left;
  } else {
    e = d.top - b.scrollTop, f = d.left - b.scrollLeft;
  }
  var g = e + b.scrollHeight, h = f + b.scrollWidth;
  if (c.right < f || c.bottom < e || c.left > h || c.top > g) {
    return !1;
  }
  a = a.ownerDocument.defaultView;
  e = a.getComputedStyle(b);
  return c.left > d.right || c.top > d.bottom ? "scroll" == e.overflow || "auto" == e.overflow || b instanceof a.HTMLBodyElement : !0;
};
axs.utils.isClippedBy = function(a, b) {
  var c = a.getBoundingClientRect(), d = b.getBoundingClientRect(), e = d.top - b.scrollTop, f = d.left - b.scrollLeft;
  a = a.ownerDocument.defaultView.getComputedStyle(b);
  return (c.right < d.left || c.bottom < d.top || c.left > d.right || c.top > d.bottom) && "hidden" == a.overflow ? !0 : c.right < f || c.bottom < e ? "visible" != a.overflow : !1;
};
axs.utils.isAncestor = function(a, b) {
  if (null == b) {
    return !1;
  }
  if (b === a) {
    return !0;
  }
  b = axs.dom.composedParentNode(b);
  return axs.utils.isAncestor(a, b);
};
axs.utils.overlappingElements = function(a) {
  if (axs.utils.elementHasZeroArea(a)) {
    return null;
  }
  for (var b = [], c = a.getClientRects(), d = 0; d < c.length; d++) {
    var e = c[d];
    e = document.elementFromPoint((e.left + e.right) / 2, (e.top + e.bottom) / 2);
    if (null != e && e != a && !axs.utils.isAncestor(e, a) && !axs.utils.isAncestor(a, e)) {
      var f = window.getComputedStyle(e, null);
      f && (f = axs.utils.getBgColor(f, e)) && 0 < f.alpha && 0 > b.indexOf(e) && b.push(e);
    }
  }
  return b;
};
axs.utils.elementIsHtmlControl = function(a) {
  var b = a.ownerDocument.defaultView;
  return a instanceof b.HTMLButtonElement || a instanceof b.HTMLInputElement || a instanceof b.HTMLSelectElement || a instanceof b.HTMLTextAreaElement ? !0 : !1;
};
axs.utils.elementIsAriaWidget = function(a) {
  return a.hasAttribute("role") && (a = a.getAttribute("role")) && (a = axs.constants.ARIA_ROLES[a]) && "widget" in a.allParentRolesSet ? !0 : !1;
};
axs.utils.elementIsVisible = function(a) {
  return axs.utils.elementIsTransparent(a) || axs.utils.elementHasZeroArea(a) || axs.utils.elementIsOutsideScrollArea(a) || axs.utils.overlappingElements(a).length ? !1 : !0;
};
axs.utils.isLargeFont = function(a) {
  var b = a.fontSize;
  a = "bold" == a.fontWeight;
  var c = b.match(/(\d+)px/);
  if (c) {
    b = parseInt(c[1], 10);
    if (c = window.getComputedStyle(document.body, null).fontSize.match(/(\d+)px/)) {
      var d = parseInt(c[1], 10);
      c = 1.2 * d;
      d *= 1.5;
    } else {
      c = 19.2, d = 24;
    }
    return a && b >= c || b >= d;
  }
  if (c = b.match(/(\d+)em/)) {
    return b = parseInt(c[1], 10), a && 1.2 <= b || 1.5 <= b ? !0 : !1;
  }
  if (c = b.match(/(\d+)%/)) {
    return b = parseInt(c[1], 10), a && 120 <= b || 150 <= b ? !0 : !1;
  }
  if (c = b.match(/(\d+)pt/)) {
    if (b = parseInt(c[1], 10), a && 14 <= b || 18 <= b) {
      return !0;
    }
  }
  return !1;
};
axs.utils.getBgColor = function(a, b) {
  var c = axs.color.parseColor(a.backgroundColor);
  if (!c) {
    return null;
  }
  1 > a.opacity && (c.alpha *= a.opacity);
  if (1 > c.alpha) {
    a = axs.utils.getParentBgColor(b);
    if (null == a) {
      return null;
    }
    c = axs.color.flattenColors(c, a);
  }
  return c;
};
axs.utils.getParentBgColor = function(a) {
  var b = a;
  a = [];
  for (var c = null; b = axs.dom.parentElement(b);) {
    var d = window.getComputedStyle(b, null);
    if (d) {
      var e = axs.color.parseColor(d.backgroundColor);
      if (e && (1 > d.opacity && (e.alpha *= d.opacity), 0 != e.alpha && (a.push(e), 1 == e.alpha))) {
        c = !0;
        break;
      }
    }
  }
  c || a.push(new axs.color.Color(255, 255, 255, 1));
  for (b = a.pop(); a.length;) {
    c = a.pop(), b = axs.color.flattenColors(c, b);
  }
  return b;
};
axs.utils.getFgColor = function(a, b, c) {
  var d = axs.color.parseColor(a.color);
  if (!d) {
    return null;
  }
  1 > d.alpha && (d = axs.color.flattenColors(d, c));
  1 > a.opacity && (b = axs.utils.getParentBgColor(b), d.alpha *= a.opacity, d = axs.color.flattenColors(d, b));
  return d;
};
axs.utils.getContrastRatioForElement = function(a) {
  var b = window.getComputedStyle(a, null);
  return axs.utils.getContrastRatioForElementWithComputedStyle(b, a);
};
axs.utils.getContrastRatioForElementWithComputedStyle = function(a, b) {
  if (axs.utils.isElementHidden(b)) {
    return null;
  }
  var c = axs.utils.getBgColor(a, b);
  return c ? (a = axs.utils.getFgColor(a, b, c)) ? axs.color.calculateContrastRatio(a, c) : null : null;
};
axs.utils.isNativeTextElement = function(a) {
  var b = a.tagName.toLowerCase();
  a = a.type ? a.type.toLowerCase() : "";
  if ("textarea" == b) {
    return !0;
  }
  if ("input" != b) {
    return !1;
  }
  switch(a) {
    case "email":
    case "number":
    case "password":
    case "search":
    case "text":
    case "tel":
    case "url":
    case "":
      return !0;
    default:
      return !1;
  }
};
axs.utils.isLowContrast = function(a, b, c) {
  a = Math.round(10 * a) / 10;
  return c ? 4.5 > a || !axs.utils.isLargeFont(b) && 7.0 > a : 3.0 > a || !axs.utils.isLargeFont(b) && 4.5 > a;
};
axs.utils.hasLabel = function(a) {
  var b = a.tagName.toLowerCase(), c = a.type ? a.type.toLowerCase() : "";
  if (a.hasAttribute("aria-label") || a.hasAttribute("title") || "img" == b && a.hasAttribute("alt") || "input" == b && "image" == c && a.hasAttribute("alt") || "input" == b && ("submit" == c || "reset" == c) || a.hasAttribute("aria-labelledby") || a.hasAttribute("id") && 0 < document.querySelectorAll('label[for="' + a.id + '"]').length) {
    return !0;
  }
  for (b = axs.dom.parentElement(a); b;) {
    if ("label" == b.tagName.toLowerCase() && b.control == a) {
      return !0;
    }
    b = axs.dom.parentElement(b);
  }
  return !1;
};
axs.utils.isNativelyDisableable = function(a) {
  return a.tagName.toUpperCase() in axs.constants.NATIVELY_DISABLEABLE;
};
axs.utils.isElementDisabled = function(a) {
  if (axs.browserUtils.matchSelector(a, "[aria-disabled=true], [aria-disabled=true] *")) {
    return !0;
  }
  if (!axs.utils.isNativelyDisableable(a) || axs.browserUtils.matchSelector(a, "fieldset>legend:first-of-type *")) {
    return !1;
  }
  for (; null !== a; a = axs.dom.parentElement(a)) {
    if (axs.utils.isNativelyDisableable(a) && a.hasAttribute("disabled")) {
      return !0;
    }
  }
  return !1;
};
axs.utils.isElementHidden = function(a) {
  if (!(a instanceof a.ownerDocument.defaultView.HTMLElement)) {
    return !1;
  }
  if (a.hasAttribute("chromevoxignoreariahidden")) {
    var b = !0;
  }
  var c = window.getComputedStyle(a, null);
  return "none" == c.display || "hidden" == c.visibility ? !0 : a.hasAttribute("aria-hidden") && "true" == a.getAttribute("aria-hidden").toLowerCase() ? !b : !1;
};
axs.utils.isElementOrAncestorHidden = function(a) {
  return axs.utils.isElementHidden(a) ? !0 : axs.dom.parentElement(a) ? axs.utils.isElementOrAncestorHidden(axs.dom.parentElement(a)) : !1;
};
axs.utils.isInlineElement = function(a) {
  a = a.tagName.toUpperCase();
  return axs.constants.InlineElements[a];
};
axs.utils.getRoles = function(a, b) {
  if (!a || a.nodeType !== Node.ELEMENT_NODE || !a.hasAttribute("role") && !b) {
    return null;
  }
  var c = a.getAttribute("role");
  !c && b && (c = axs.properties.getImplicitRole(a));
  if (!c) {
    return null;
  }
  a = c.split(" ");
  b = {roles:[], valid:!1};
  for (c = 0; c < a.length; c++) {
    var d = a[c], e = axs.constants.ARIA_ROLES[d];
    d = {name:d};
    e && !e.abstract ? (d.details = e, b.applied || (b.applied = d), d.valid = b.valid = !0) : d.valid = !1;
    b.roles.push(d);
  }
  return b;
};
axs.utils.getAriaPropertyValue = function(a, b, c) {
  var d = a.replace(/^aria-/, ""), e = axs.constants.ARIA_PROPERTIES[d];
  d = {name:a, rawValue:b};
  if (!e) {
    return d.valid = !1, d.reason = '"' + a + '" is not a valid ARIA property', d;
  }
  e = e.valueType;
  if (!e) {
    return d.valid = !1, d.reason = '"' + a + '" is not a valid ARIA property', d;
  }
  switch(e) {
    case "idref":
      a = axs.utils.isValidIDRefValue(b, c), d.valid = a.valid, d.reason = a.reason, d.idref = a.idref;
    case "idref_list":
      a = b.split(/\s+/);
      d.valid = !0;
      for (b = 0; b < a.length; b++) {
        e = axs.utils.isValidIDRefValue(a[b], c), e.valid || (d.valid = !1), d.values ? d.values.push(e) : d.values = [e];
      }
      return d;
    case "integer":
      c = axs.utils.isValidNumber(b);
      if (!c.valid) {
        return d.valid = !1, d.reason = c.reason, d;
      }
      Math.floor(c.value) !== c.value ? (d.valid = !1, d.reason = "" + b + " is not a whole integer") : (d.valid = !0, d.value = c.value);
      return d;
    case "decimal":
    case "number":
      c = axs.utils.isValidNumber(b);
      d.valid = c.valid;
      if (!c.valid) {
        return d.reason = c.reason, d;
      }
      d.value = c.value;
      return d;
    case "string":
      return d.valid = !0, d.value = b, d;
    case "token":
      return c = axs.utils.isValidTokenValue(a, b.toLowerCase()), c.valid ? (d.valid = !0, d.value = c.value) : (d.valid = !1, d.value = b, d.reason = c.reason), d;
    case "token_list":
      e = b.split(/\s+/);
      d.valid = !0;
      for (b = 0; b < e.length; b++) {
        c = axs.utils.isValidTokenValue(a, e[b].toLowerCase()), c.valid || (d.valid = !1, d.reason ? (d.reason = [d.reason], d.reason.push(c.reason)) : (d.reason = c.reason, d.possibleValues = c.possibleValues)), d.values ? d.values.push(c.value) : d.values = [c.value];
      }
      return d;
    case "tristate":
      return c = axs.utils.isPossibleValue(b.toLowerCase(), axs.constants.MIXED_VALUES, a), c.valid ? (d.valid = !0, d.value = c.value) : (d.valid = !1, d.value = b, d.reason = c.reason), d;
    case "boolean":
      return c = axs.utils.isValidBoolean(b), c.valid ? (d.valid = !0, d.value = c.value) : (d.valid = !1, d.value = b, d.reason = c.reason), d;
  }
  d.valid = !1;
  d.reason = "Not a valid ARIA property";
  return d;
};
axs.utils.isValidTokenValue = function(a, b) {
  var c = a.replace(/^aria-/, "");
  return axs.utils.isPossibleValue(b, axs.constants.ARIA_PROPERTIES[c].valuesSet, a);
};
axs.utils.isPossibleValue = function(a, b, c) {
  return b[a] ? {valid:!0, value:a} : {valid:!1, value:a, reason:'"' + a + '" is not a valid value for ' + c, possibleValues:Object.keys(b)};
};
axs.utils.isValidBoolean = function(a) {
  try {
    var b = JSON.parse(a);
  } catch (c) {
    b = "";
  }
  return "boolean" != typeof b ? {valid:!1, value:a, reason:'"' + a + '" is not a true/false value'} : {valid:!0, value:b};
};
axs.utils.isValidIDRefValue = function(a, b) {
  return 0 == a.length ? {valid:!0, idref:a} : b.ownerDocument.getElementById(a) ? {valid:!0, idref:a} : {valid:!1, idref:a, reason:'No element with ID "' + a + '"'};
};
axs.utils.isValidNumber = function(a) {
  var b = {valid:!1, value:a, reason:'"' + a + '" is not a number'};
  if (!a) {
    return b;
  }
  if (/^0x/i.test(a)) {
    return b.reason = '"' + a + '" is not a decimal number', b;
  }
  a *= 1;
  return isFinite(a) ? {valid:!0, value:a} : b;
};
axs.utils.isElementImplicitlyFocusable = function(a) {
  var b = a.ownerDocument.defaultView;
  return a instanceof b.HTMLAnchorElement || a instanceof b.HTMLAreaElement ? a.hasAttribute("href") : a instanceof b.HTMLInputElement || a instanceof b.HTMLSelectElement || a instanceof b.HTMLTextAreaElement || a instanceof b.HTMLButtonElement || a instanceof b.HTMLIFrameElement ? !a.disabled : !1;
};
axs.utils.values = function(a) {
  var b = [], c;
  for (c in a) {
    a.hasOwnProperty(c) && "function" != typeof a[c] && b.push(a[c]);
  }
  return b;
};
axs.utils.namedValues = function(a) {
  var b = {}, c;
  for (c in a) {
    a.hasOwnProperty(c) && "function" != typeof a[c] && (b[c] = a[c]);
  }
  return b;
};
axs.utils.getQuerySelectorText = function(a) {
  if (null == a || "HTML" == a.tagName) {
    return "html";
  }
  if ("BODY" == a.tagName) {
    return "body";
  }
  if (a.hasAttribute) {
    if (a.id) {
      return "#" + a.id;
    }
    if (a.className) {
      for (var b = "", c = 0; c < a.classList.length; c++) {
        b += "." + a.classList[c];
      }
      var d = 0;
      if (a.parentNode) {
        for (c = 0; c < a.parentNode.children.length; c++) {
          var e = a.parentNode.children[c];
          axs.browserUtils.matchSelector(e, b) && d++;
          if (e === a) {
            break;
          }
        }
      } else {
        d = 1;
      }
      if (1 == d) {
        return axs.utils.getQuerySelectorText(a.parentNode) + " > " + b;
      }
    }
    if (a.parentNode) {
      b = a.parentNode.children;
      d = 1;
      for (c = 0; b[c] !== a;) {
        b[c].tagName == a.tagName && d++, c++;
      }
      c = "";
      "BODY" != a.parentNode.tagName && (c = axs.utils.getQuerySelectorText(a.parentNode) + " > ");
      return 1 == d ? c + a.tagName : c + a.tagName + ":nth-of-type(" + d + ")";
    }
  } else {
    if (a.selectorText) {
      return a.selectorText;
    }
  }
  return "";
};
axs.utils.getAriaIdReferrers = function(a, b) {
  var c = function(a) {
    var b = axs.constants.ARIA_PROPERTIES[a];
    if (b) {
      if ("idref" === b.valueType) {
        return "[aria-" + a + "='" + d + "']";
      }
      if ("idref_list" === b.valueType) {
        return "[aria-" + a + "~='" + d + "']";
      }
    }
    return "";
  };
  if (!a) {
    return null;
  }
  var d = a.id;
  if (!d) {
    return null;
  }
  d = d.replace(/'/g, "\\'");
  if (b) {
    var e = b.replace(/^aria-/, "");
    if (b = c(e)) {
      return a.ownerDocument.querySelectorAll(b);
    }
  } else {
    var f = [];
    for (e in axs.constants.ARIA_PROPERTIES) {
      (b = c(e)) && f.push(b);
    }
    return a.ownerDocument.querySelectorAll(f.join(","));
  }
  return null;
};
axs.utils.getHtmlIdReferrers = function(a) {
  if (!a) {
    return null;
  }
  var b = a.id;
  if (!b) {
    return null;
  }
  b = b.replace(/'/g, "\\'");
  var c = "[contextmenu='{id}'] [itemref~='{id}'] button[form='{id}'] button[menu='{id}'] fieldset[form='{id}'] input[form='{id}'] input[list='{id}'] keygen[form='{id}'] label[for='{id}'] label[form='{id}'] menuitem[command='{id}'] object[form='{id}'] output[for~='{id}'] output[form='{id}'] select[form='{id}'] td[headers~='{id}'] textarea[form='{id}'] tr[headers~='{id}']".split(" ").map(function(a) {
    return a.replace("{id}", b);
  });
  return a.ownerDocument.querySelectorAll(c.join(","));
};
axs.utils.getIdReferrers = function(a) {
  var b = [], c = axs.utils.getHtmlIdReferrers(a);
  c && (b = b.concat(Array.prototype.slice.call(c)));
  (c = axs.utils.getAriaIdReferrers(a)) && (b = b.concat(Array.prototype.slice.call(c)));
  return b;
};
axs.utils.getIdReferents = function(a, b) {
  var c = [], d = a.replace(/^aria-/, "");
  d = axs.constants.ARIA_PROPERTIES[d];
  if (!d || !b.hasAttribute(a)) {
    return c;
  }
  d = d.valueType;
  if ("idref_list" === d || "idref" === d) {
    d = b.ownerDocument;
    a = b.getAttribute(a);
    a = a.split(/\s+/);
    b = 0;
    for (var e = a.length; b < e; b++) {
      var f = d.getElementById(a[b]);
      f && (c[c.length] = f);
    }
  }
  return c;
};
axs.utils.getAriaPropertiesByValueType = function(a) {
  var b = {}, c;
  for (c in axs.constants.ARIA_PROPERTIES) {
    var d = axs.constants.ARIA_PROPERTIES[c];
    d && 0 <= a.indexOf(d.valueType) && (b[c] = d);
  }
  return b;
};
axs.utils.getSelectorForAriaProperties = function(a) {
  a = Object.keys(a).map(function(a) {
    return "[aria-" + a + "]";
  });
  a.sort();
  return a.join(",");
};
axs.utils.findDescendantsWithRole = function(a, b) {
  if (!a || !b) {
    return [];
  }
  b = axs.properties.getSelectorForRole(b);
  if (b && (a = a.querySelectorAll(b))) {
    a = Array.prototype.map.call(a, function(a) {
      return a;
    });
  } else {
    return [];
  }
  return a;
};

