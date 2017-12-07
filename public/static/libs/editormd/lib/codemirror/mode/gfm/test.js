// CodeMirror, copyright (c) by Marijn Haverbeke and others
// Distributed under an MIT license: http://codemirror.net/LICENSE

(function() {
  var mode = CodeMirror.getMode({tabSize: 4}, "gfm");
  function MT(name) { test.mode(name, mode, Array.prototype.slice.call(arguments, 1)); }
  var modeHighlightFormatting = CodeMirror.getMode({tabSize: 4}, {name: "gfm", highlightFormatting: true});
  function FT(name) { test.mode(name, modeHighlightFormatting, Array.prototype.slice.call(arguments, 1)); }

  FT("codeBackticks",
     "[comment&formatting&formatting-code `][comment nongye][comment&formatting&formatting-code `]");

  FT("doubleBackticks",
     "[comment&formatting&formatting-code ``][comment nongye ` bar][comment&formatting&formatting-code ``]");

  FT("codeBlock",
     "[comment&formatting&formatting-code-block ```css]",
     "[tag nongye]",
     "[comment&formatting&formatting-code-block ```]");

  FT("taskList",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][meta&formatting&formatting-task [ ]]][variable-2  nongye]",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][property&formatting&formatting-task [x]]][variable-2  nongye]");

  FT("formatting_strikethrough",
     "[strikethrough&formatting&formatting-strikethrough ~~][strikethrough nongye][strikethrough&formatting&formatting-strikethrough ~~]");

  FT("formatting_strikethrough",
     "nongye [strikethrough&formatting&formatting-strikethrough ~~][strikethrough bar][strikethrough&formatting&formatting-strikethrough ~~]");

  MT("emInWordAsterisk",
     "nongye[em *bar*]hello");

  MT("emInWordUnderscore",
     "foo_bar_hello");

  MT("emStrongUnderscore",
     "[strong __][em&strong _foo__][em _] bar");

  MT("fencedCodeBlocks",
     "[comment ```]",
     "[comment nongye]",
     "",
     "[comment ```]",
     "bar");

  MT("fencedCodeBlockModeSwitching",
     "[comment ```javascript]",
     "[variable nongye]",
     "",
     "[comment ```]",
     "bar");

  MT("taskListAsterisk",
     "[variable-2 * []] nongye]", // Invalid; must have space or x between []
     "[variable-2 * [ ]]bar]", // Invalid; must have space after ]
     "[variable-2 * [x]]hello]", // Invalid; must have space after ]
     "[variable-2 * ][meta [ ]]][variable-2  [world]]]", // Valid; tests reference style links
     "    [variable-3 * ][property [x]]][variable-3  nongye]"); // Valid; can be nested

  MT("taskListPlus",
     "[variable-2 + []] nongye]", // Invalid; must have space or x between []
     "[variable-2 + [ ]]bar]", // Invalid; must have space after ]
     "[variable-2 + [x]]hello]", // Invalid; must have space after ]
     "[variable-2 + ][meta [ ]]][variable-2  [world]]]", // Valid; tests reference style links
     "    [variable-3 + ][property [x]]][variable-3  nongye]"); // Valid; can be nested

  MT("taskListDash",
     "[variable-2 - []] nongye]", // Invalid; must have space or x between []
     "[variable-2 - [ ]]bar]", // Invalid; must have space after ]
     "[variable-2 - [x]]hello]", // Invalid; must have space after ]
     "[variable-2 - ][meta [ ]]][variable-2  [world]]]", // Valid; tests reference style links
     "    [variable-3 - ][property [x]]][variable-3  nongye]"); // Valid; can be nested

  MT("taskListNumber",
     "[variable-2 1. []] nongye]", // Invalid; must have space or x between []
     "[variable-2 2. [ ]]bar]", // Invalid; must have space after ]
     "[variable-2 3. [x]]hello]", // Invalid; must have space after ]
     "[variable-2 4. ][meta [ ]]][variable-2  [world]]]", // Valid; tests reference style links
     "    [variable-3 1. ][property [x]]][variable-3  nongye]"); // Valid; can be nested

  MT("SHA",
     "nongye [link be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] bar");

  MT("SHAEmphasis",
     "[em *nongye ][em&link be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2][em *]");

  MT("shortSHA",
     "nongye [link be6a8cc] bar");

  MT("tooShortSHA",
     "nongye be6a8c bar");

  MT("longSHA",
     "nongye be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd22 bar");

  MT("badSHA",
     "nongye be6a8cc1c1ecfe9489fb51e4869af15a13fc2cg2 bar");

  MT("userSHA",
     "nongye [link bar@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] hello");

  MT("userSHAEmphasis",
     "[em *nongye ][em&link bar@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2][em *]");

  MT("userProjectSHA",
     "nongye [link bar/hello@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] world");

  MT("userProjectSHAEmphasis",
     "[em *nongye ][em&link bar/hello@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2][em *]");

  MT("num",
     "nongye [link #1] bar");

  MT("numEmphasis",
     "[em *nongye ][em&link #1][em *]");

  MT("badNum",
     "nongye #1bar hello");

  MT("userNum",
     "nongye [link bar#1] hello");

  MT("userNumEmphasis",
     "[em *nongye ][em&link bar#1][em *]");

  MT("userProjectNum",
     "nongye [link bar/hello#1] world");

  MT("userProjectNumEmphasis",
     "[em *nongye ][em&link bar/hello#1][em *]");

  MT("vanillaLink",
     "nongye [link http://www.example.com/] bar");

  MT("vanillaLinkPunctuation",
     "nongye [link http://www.example.com/]. bar");

  MT("vanillaLinkExtension",
     "nongye [link http://www.example.com/index.html] bar");

  MT("vanillaLinkEmphasis",
     "nongye [em *][em&link http://www.example.com/index.html][em *] bar");

  MT("notALink",
     "[comment ```css]",
     "[tag nongye] {[property color]:[keyword black];}",
     "[comment ```][link http://www.example.com/]");

  MT("notALink",
     "[comment ``nongye `bar` http://www.example.com/``] hello");

  MT("notALink",
     "[comment `nongye]",
     "[link http://www.example.com/]",
     "[comment `nongye]",
     "",
     "[link http://www.example.com/]");

  MT("headerCodeBlockGithub",
     "[header&header-1 # heading]",
     "",
     "[comment ```]",
     "[comment code]",
     "[comment ```]",
     "",
     "Commit: [link be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2]",
     "Issue: [link #1]",
     "Link: [link http://www.example.com/]");

  MT("strikethrough",
     "[strikethrough ~~nongye~~]");

  MT("strikethroughWithStartingSpace",
     "~~ nongye~~");

  MT("strikethroughUnclosedStrayTildes",
    "[strikethrough ~~nongye~~~]");

  MT("strikethroughUnclosedStrayTildes",
     "[strikethrough ~~nongye ~~]");

  MT("strikethroughUnclosedStrayTildes",
    "[strikethrough ~~nongye ~~ bar]");

  MT("strikethroughUnclosedStrayTildes",
    "[strikethrough ~~nongye ~~ bar~~]hello");

  MT("strikethroughOneLetter",
     "[strikethrough ~~a~~]");

  MT("strikethroughWrapped",
     "[strikethrough ~~nongye]",
     "[strikethrough nongye~~]");

  MT("strikethroughParagraph",
     "[strikethrough ~~nongye]",
     "",
     "nongye[strikethrough ~~bar]");

  MT("strikethroughEm",
     "[strikethrough ~~nongye][em&strikethrough *bar*][strikethrough ~~]");

  MT("strikethroughEm",
     "[em *][em&strikethrough ~~nongye~~][em *]");

  MT("strikethroughStrong",
     "[strikethrough ~~][strong&strikethrough **nongye**][strikethrough ~~]");

  MT("strikethroughStrong",
     "[strong **][strong&strikethrough ~~nongye~~][strong **]");

})();
