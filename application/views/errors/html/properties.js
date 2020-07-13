if (!axs) var axs = {}; if (!goog) var goog = {}; axs.properties = {};
axs.properties.TEXT_CONTENT_XPATH = './/text()[normalize-space(.)!=""]/parent::*[name()!="script"]';
axs.properties.getFocusProperties = function(a) {
  var b = {}, c = a.getAttribute("tabindex");
  void 0 != c ? b.tabindex = {value:c, valid:!0} : axs.utils.isElementImplicitlyFocusable(a) && (b.implicitlyFocusable = {value:!0, valid:!0});
  if (0 == Object.keys(b).length) {
    return null;
  }
  var d = axs.utils.elementIsTransparent(a), e = axs.utils.elementHasZeroArea(a), f = axs.utils.elementIsOutsideScrollArea(a), g = axs.utils.overlappingElements(a);
  if (d || e || f || 0 < g.length) {
    c = axs.utils.isElementOrAncestorHidden(a);
    var h = {value:!1, valid:c};
    d && (h.transparent = !0);
    e && (h.zeroArea = !0);
    f && (h.outsideScrollArea = !0);
    g && 0 < g.length && (h.overlappingElements = g);
    d = {value:c, valid:c};
    c && (d.reason = axs.properties.getHiddenReason(a));
    h.hidden = d;
    b.visible = h;
  } else {
    b.visible = {value:!0, valid:!0};
  }
  return b;
};
axs.properties.getHiddenReason = function(a) {
  if (!(a && a instanceof a.ownerDocument.defaultView.HTMLElement)) {
    return null;
  }
  if (a.hasAttribute("chromevoxignoreariahidden")) {
    var b = !0;
  }
  var c = window.getComputedStyle(a, null);
  return "none" == c.display ? {property:"display: none", on:a} : "hidden" == c.visibility ? {property:"visibility: hidden", on:a} : a.hasAttribute("aria-hidden") && "true" == a.getAttribute("aria-hidden").toLowerCase() && !b ? {property:"aria-hidden", on:a} : axs.properties.getHiddenReason(axs.dom.parentElement(a));
};
axs.properties.getColorProperties = function(a) {
  var b = {};
  (a = axs.properties.getContrastRatioProperties(a)) && (b.contrastRatio = a);
  return 0 == Object.keys(b).length ? null : b;
};
axs.properties.hasDirectTextDescendant = function(a) {
  function b() {
    for (var b = c.evaluate(axs.properties.TEXT_CONTENT_XPATH, a, null, XPathResult.ANY_TYPE, null), e = b.iterateNext(); null != e; e = b.iterateNext()) {
      if (e === a) {
        return !0;
      }
    }
    return !1;
  }
  var c = a.nodeType == Node.DOCUMENT_NODE ? a : a.ownerDocument;
  return c.evaluate ? b() : function() {
    for (var b = c.createTreeWalker(a, NodeFilter.SHOW_TEXT, null, !1); b.nextNode();) {
      var e = b.currentNode, f = e.parentNode.tagName.toLowerCase();
      if (e.nodeValue.trim() && "script" !== f && a !== e) {
        return !0;
      }
    }
    return !1;
  }();
};
axs.properties.getContrastRatioProperties = function(a) {
  if (!axs.properties.hasDirectTextDescendant(a)) {
    return null;
  }
  var b = {}, c = window.getComputedStyle(a, null), d = axs.utils.getBgColor(c, a);
  if (!d) {
    return null;
  }
  b.backgroundColor = axs.color.colorToString(d);
  var e = axs.utils.getFgColor(c, a, d);
  b.foregroundColor = axs.color.colorToString(e);
  a = axs.utils.getContrastRatioForElementWithComputedStyle(c, a);
  if (!a) {
    return null;
  }
  b.value = a.toFixed(2);
  axs.utils.isLowContrast(a, c) && (b.alert = !0);
  var f = axs.utils.isLargeFont(c) ? 3.0 : 4.5;
  c = axs.utils.isLargeFont(c) ? 4.5 : 7.0;
  var g = {};
  f > a && (g.AA = f);
  c > a && (g.AAA = c);
  if (!Object.keys(g).length) {
    return b;
  }
  (d = axs.color.suggestColors(d, e, g)) && Object.keys(d).length && (b.suggestedColors = d);
  return b;
};
axs.properties.findTextAlternatives = function(a, b, c, d) {
  var e = c || !1;
  c = axs.dom.asElement(a);
  if (!c || !d && axs.utils.isElementOrAncestorHidden(c)) {
    return null;
  }
  if (a.nodeType == Node.TEXT_NODE) {
    return c = {type:"text"}, c.text = a.textContent, c.lastWord = axs.properties.getLastWord(c.text), b.content = c, a.textContent;
  }
  a = null;
  e || (a = axs.properties.getTextFromAriaLabelledby(c, b));
  if (c.hasAttribute("aria-label")) {
    var f = {type:"text"};
    f.text = c.getAttribute("aria-label");
    f.lastWord = axs.properties.getLastWord(f.text);
    a ? f.unused = !0 : e && axs.utils.elementIsHtmlControl(c) || (a = f.text);
    b.ariaLabel = f;
  }
  c.hasAttribute("role") && "presentation" == c.getAttribute("role") || (a = axs.properties.getTextFromHostLanguageAttributes(c, b, a, e));
  e && axs.utils.elementIsHtmlControl(c) && (f = c.ownerDocument.defaultView, c instanceof f.HTMLInputElement && ("text" == c.type && c.value && 0 < c.value.length && (b.controlValue = {text:c.value}), "range" == c.type && (b.controlValue = {text:c.value})), c instanceof f.HTMLSelectElement && (b.controlValue = {text:c.value}), b.controlValue && (f = b.controlValue, a ? f.unused = !0 : a = f.text));
  if (e && axs.utils.elementIsAriaWidget(c)) {
    e = c.getAttribute("role");
    "textbox" == e && c.textContent && 0 < c.textContent.length && (b.controlValue = {text:c.textContent});
    if ("slider" == e || "spinbutton" == e) {
      c.hasAttribute("aria-valuetext") ? b.controlValue = {text:c.getAttribute("aria-valuetext")} : c.hasAttribute("aria-valuenow") && (b.controlValue = {value:c.getAttribute("aria-valuenow"), text:"" + c.getAttribute("aria-valuenow")});
    }
    if ("menu" == e) {
      var g = c.querySelectorAll("[role=menuitemcheckbox], [role=menuitemradio]");
      f = [];
      for (var h = 0; h < g.length; h++) {
        "true" == g[h].getAttribute("aria-checked") && f.push(g[h]);
      }
      if (0 < f.length) {
        g = "";
        for (h = 0; h < f.length; h++) {
          g += axs.properties.findTextAlternatives(f[h], {}, !0), h < f.length - 1 && (g += ", ");
        }
        b.controlValue = {text:g};
      }
    }
    if ("combobox" == e || "select" == e) {
      b.controlValue = {text:"TODO"};
    }
    b.controlValue && (f = b.controlValue, a ? f.unused = !0 : a = f.text);
  }
  f = !0;
  c.hasAttribute("role") && (e = c.getAttribute("role"), (e = axs.constants.ARIA_ROLES[e]) && (!e.namefrom || 0 > e.namefrom.indexOf("contents")) && (f = !1));
  (d = axs.properties.getTextFromDescendantContent(c, d)) && f && (e = {type:"text"}, e.text = d, e.lastWord = axs.properties.getLastWord(e.text), a ? e.unused = !0 : a = d, b.content = e);
  c.hasAttribute("title") && (d = {type:"string", valid:!0}, d.text = c.getAttribute("title"), d.lastWord = axs.properties.getLastWord(d.lastWord), a ? d.unused = !0 : a = d.text, b.title = d);
  return 0 == Object.keys(b).length && null == a ? null : a;
};
axs.properties.getTextFromDescendantContent = function(a, b) {
  var c = a.childNodes;
  a = [];
  for (var d = 0; d < c.length; d++) {
    var e = axs.properties.findTextAlternatives(c[d], {}, !0, b);
    e && a.push(e.trim());
  }
  if (a.length) {
    b = "";
    for (d = 0; d < a.length; d++) {
      b = [b, a[d]].join(" ").trim();
    }
    return b;
  }
  return null;
};
axs.properties.getTextFromAriaLabelledby = function(a, b) {
  var c = null;
  if (!a.hasAttribute("aria-labelledby")) {
    return c;
  }
  a = a.getAttribute("aria-labelledby").split(/\s+/);
  for (var d = {valid:!0}, e = [], f = [], g = 0; g < a.length; g++) {
    var h = {type:"element"}, k = a[g];
    h.value = k;
    var n = document.getElementById(k);
    n ? (h.valid = !0, h.text = axs.properties.findTextAlternatives(n, {}, !0, !0), h.lastWord = axs.properties.getLastWord(h.text), e.push(h.text), h.element = n) : (h.valid = !1, d.valid = !1, h.errorMessage = {messageKey:"noElementWithId", args:[k]});
    f.push(h);
  }
  0 < f.length && (f[f.length - 1].last = !0, d.values = f, d.text = e.join(" "), d.lastWord = axs.properties.getLastWord(d.text), c = d.text, b.ariaLabelledby = d);
  return c;
};
axs.properties.getTextFromHostLanguageAttributes = function(a, b, c, d) {
  if (axs.browserUtils.matchSelector(a, "img") && a.hasAttribute("alt")) {
    var e = {type:"string", valid:!0};
    e.text = a.getAttribute("alt");
    c ? e.unused = !0 : c = e.text;
    b.alt = e;
  }
  if (axs.browserUtils.matchSelector(a, 'input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), video:not([disabled])') && !d) {
    if (a.hasAttribute("id")) {
      d = document.querySelectorAll('label[for="' + a.id + '"]');
      e = {};
      for (var f = [], g = [], h = 0; h < d.length; h++) {
        var k = {type:"element"}, n = d[h], l = axs.properties.findTextAlternatives(n, {}, !0);
        l && 0 < l.trim().length && (k.text = l.trim(), g.push(l.trim()));
        k.element = n;
        f.push(k);
      }
      0 < f.length && (f[f.length - 1].last = !0, e.values = f, e.text = g.join(" "), e.lastWord = axs.properties.getLastWord(e.text), c ? e.unused = !0 : c = e.text, b.labelFor = e);
    }
    d = axs.dom.parentElement(a);
    for (e = {}; d;) {
      if ("label" == d.tagName.toLowerCase() && (f = d, f.control == a)) {
        e.type = "element";
        e.text = axs.properties.findTextAlternatives(f, {}, !0);
        e.lastWord = axs.properties.getLastWord(e.text);
        e.element = f;
        break;
      }
      d = axs.dom.parentElement(d);
    }
    e.text && (c ? e.unused = !0 : c = e.text, b.labelWrapped = e);
    axs.browserUtils.matchSelector(a, 'input[type="image"]') && a.hasAttribute("alt") && (e = {type:"string", valid:!0}, e.text = a.getAttribute("alt"), c ? e.unused = !0 : c = e.text, b.alt = e);
    Object.keys(b).length || (b.noLabel = !0);
  }
  return c;
};
axs.properties.getLastWord = function(a) {
  if (!a) {
    return null;
  }
  var b = a.lastIndexOf(" ") + 1, c = a.length - 10;
  return a.substring(b > c ? b : c);
};
axs.properties.getTextProperties = function(a) {
  var b = {}, c = axs.properties.findTextAlternatives(a, b, !1, !0);
  if (0 == Object.keys(b).length && ((a = axs.dom.asElement(a)) && axs.browserUtils.matchSelector(a, "img") && (b.alt = {valid:!1, errorMessage:"No alt value provided"}, a = a.src, "string" == typeof a && (c = a.split("/").pop(), b.filename = {text:c})), !c)) {
    return null;
  }
  b.hasProperties = !!Object.keys(b).length;
  b.computedText = c;
  b.lastWord = axs.properties.getLastWord(c);
  return b;
};
axs.properties.getAriaProperties = function(a) {
  var b = {}, c = axs.properties.getGlobalAriaProperties(a), d;
  for (d in axs.constants.ARIA_PROPERTIES) {
    var e = "aria-" + d;
    if (a.hasAttribute(e)) {
      var f = a.getAttribute(e);
      c[e] = axs.utils.getAriaPropertyValue(e, f, a);
    }
  }
  0 < Object.keys(c).length && (b.properties = axs.utils.values(c));
  f = axs.utils.getRoles(a);
  if (!f) {
    return Object.keys(b).length ? b : null;
  }
  b.roles = f;
  if (!f.valid || !f.roles) {
    return b;
  }
  e = f.roles;
  for (var g = 0; g < e.length; g++) {
    var h = e[g];
    if (h.details && h.details.propertiesSet) {
      for (d in h.details.propertiesSet) {
        d in c || (a.hasAttribute(d) ? (f = a.getAttribute(d), c[d] = axs.utils.getAriaPropertyValue(d, f, a), "values" in c[d] && (f = c[d].values, f[f.length - 1].isLast = !0)) : h.details.requiredPropertiesSet[d] && (c[d] = {name:d, valid:!1, reason:"Required property not set"}));
      }
    }
  }
  0 < Object.keys(c).length && (b.properties = axs.utils.values(c));
  return 0 < Object.keys(b).length ? b : null;
};
axs.properties.getGlobalAriaProperties = function(a) {
  var b = {}, c;
  for (c in axs.constants.GLOBAL_PROPERTIES) {
    if (a.hasAttribute(c)) {
      var d = a.getAttribute(c);
      b[c] = axs.utils.getAriaPropertyValue(c, d, a);
    }
  }
  return b;
};
axs.properties.getVideoProperties = function(a) {
  if (!axs.browserUtils.matchSelector(a, "video")) {
    return null;
  }
  var b = {};
  b.captionTracks = axs.properties.getTrackElements(a, "captions");
  b.descriptionTracks = axs.properties.getTrackElements(a, "descriptions");
  b.chapterTracks = axs.properties.getTrackElements(a, "chapters");
  return b;
};
axs.properties.getTrackElements = function(a, b) {
  a = a.querySelectorAll("track[kind=" + b + "]");
  var c = {};
  if (!a.length) {
    return c.valid = !1, c.reason = {messageKey:"noTracksProvided", args:[[b]]}, c;
  }
  c.valid = !0;
  b = [];
  for (var d = 0; d < a.length; d++) {
    var e = {}, f = a[d].getAttribute("src"), g = a[d].getAttribute("srcLang"), h = a[d].getAttribute("label");
    f ? (e.valid = !0, e.src = f) : (e.valid = !1, e.reason = {messageKey:"noSrcProvided"});
    f = "";
    h && (f += h, g && (f += " "));
    g && (f += "(" + g + ")");
    "" == f && (f = "[[object Object]]");
    e.name = f;
    b.push(e);
  }
  c.values = b;
  return c;
};
axs.properties.getAllProperties = function(a) {
  var b = axs.dom.asElement(a);
  if (!b) {
    return {};
  }
  var c = {};
  c.ariaProperties = axs.properties.getAriaProperties(b);
  c.colorProperties = axs.properties.getColorProperties(b);
  c.focusProperties = axs.properties.getFocusProperties(b);
  c.textProperties = axs.properties.getTextProperties(a);
  c.videoProperties = axs.properties.getVideoProperties(b);
  return c;
};
(function() {
  function a(a) {
    if (!a) {
      return null;
    }
    var b = a.tagName;
    if (!b) {
      return null;
    }
    b = b.toUpperCase();
    b = axs.constants.TAG_TO_IMPLICIT_SEMANTIC_INFO[b];
    if (!b || !b.length) {
      return null;
    }
    for (var d = null, e = 0, f = b.length; e < f; e++) {
      var g = b[e];
      if (g.selector) {
        if (axs.browserUtils.matchSelector(a, g.selector)) {
          return g;
        }
      } else {
        d = g;
      }
    }
    return d;
  }
  axs.properties.getImplicitRole = function(b) {
    return (b = a(b)) ? b.role : "";
  };
  axs.properties.canTakeAriaAttributes = function(b) {
    return (b = a(b)) ? !b.reserved : !0;
  };
})();
axs.properties.getNativelySupportedAttributes = function(a) {
  var b = [];
  if (!a) {
    return b;
  }
  a = a.cloneNode(!1);
  for (var c = Object.keys(axs.constants.ARIA_TO_HTML_ATTRIBUTE), d = 0; d < c.length; d++) {
    var e = c[d];
    axs.constants.ARIA_TO_HTML_ATTRIBUTE[e] in a && (b[b.length] = e);
  }
  return b;
};
(function() {
  var a = {};
  axs.properties.getSelectorForRole = function(b) {
    if (!b) {
      return "";
    }
    if (a[b] && a.hasOwnProperty(b)) {
      return a[b];
    }
    var c = ['[role="' + b + '"]'];
    Object.keys(axs.constants.TAG_TO_IMPLICIT_SEMANTIC_INFO).forEach(function(a) {
      var d = axs.constants.TAG_TO_IMPLICIT_SEMANTIC_INFO[a];
      if (d && d.length) {
        for (var f = 0; f < d.length; f++) {
          var g = d[f];
          if (g.role === b) {
            if (g.selector) {
              c[c.length] = g.selector;
            } else {
              c[c.length] = a;
              break;
            }
          }
        }
      }
    });
    return a[b] = c.join(",");
  };
})();

