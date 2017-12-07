// CodeMirror, copyright (c) by Marijn Haverbeke and others
// Distributed under an MIT license: http://codemirror.net/LICENSE

(function() {
  var mode = CodeMirror.getMode({tabSize: 4}, "markdown");
  function MT(name) { test.mode(name, mode, Array.prototype.slice.call(arguments, 1)); }
  var modeHighlightFormatting = CodeMirror.getMode({tabSize: 4}, {name: "markdown", highlightFormatting: true});
  function FT(name) { test.mode(name, modeHighlightFormatting, Array.prototype.slice.call(arguments, 1)); }

  FT("formatting_emAsterisk",
     "[em&formatting&formatting-em *][em nongye][em&formatting&formatting-em *]");

  FT("formatting_emUnderscore",
     "[em&formatting&formatting-em _][em nongye][em&formatting&formatting-em _]");

  FT("formatting_strongAsterisk",
     "[strong&formatting&formatting-strong **][strong nongye][strong&formatting&formatting-strong **]");

  FT("formatting_strongUnderscore",
     "[strong&formatting&formatting-strong __][strong nongye][strong&formatting&formatting-strong __]");

  FT("formatting_codeBackticks",
     "[comment&formatting&formatting-code `][comment nongye][comment&formatting&formatting-code `]");

  FT("formatting_doubleBackticks",
     "[comment&formatting&formatting-code ``][comment nongye ` bar][comment&formatting&formatting-code ``]");

  FT("formatting_atxHeader",
     "[header&header-1&formatting&formatting-header&formatting-header-1 #][header&header-1  nongye # bar ][header&header-1&formatting&formatting-header&formatting-header-1 #]");

  FT("formatting_setextHeader",
     "nongye",
     "[header&header-1&formatting&formatting-header&formatting-header-1 =]");

  FT("formatting_blockquote",
     "[quote&quote-1&formatting&formatting-quote&formatting-quote-1 > ][quote&quote-1 nongye]");

  FT("formatting_list",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][variable-2 nongye]");
  FT("formatting_list",
     "[variable-2&formatting&formatting-list&formatting-list-ol 1. ][variable-2 nongye]");

  FT("formatting_link",
     "[link&formatting&formatting-link [][link nongye][link&formatting&formatting-link ]]][string&formatting&formatting-link-string (][string http://example.com/][string&formatting&formatting-link-string )]");

  FT("formatting_linkReference",
     "[link&formatting&formatting-link [][link nongye][link&formatting&formatting-link ]]][string&formatting&formatting-link-string [][string bar][string&formatting&formatting-link-string ]]]",
     "[link&formatting&formatting-link [][link bar][link&formatting&formatting-link ]]:] [string http://example.com/]");

  FT("formatting_linkWeb",
     "[link&formatting&formatting-link <][link http://example.com/][link&formatting&formatting-link >]");

  FT("formatting_linkEmail",
     "[link&formatting&formatting-link <][link user@example.com][link&formatting&formatting-link >]");

  FT("formatting_escape",
     "[formatting-escape \\*]");

  MT("plainText",
     "nongye");

  // Don't style single trailing space
  MT("trailingSpace1",
     "nongye ");

  // Two or more trailing spaces should be styled with line break character
  MT("trailingSpace2",
     "nongye[trailing-space-a  ][trailing-space-new-line  ]");

  MT("trailingSpace3",
     "nongye[trailing-space-a  ][trailing-space-b  ][trailing-space-new-line  ]");

  MT("trailingSpace4",
     "nongye[trailing-space-a  ][trailing-space-b  ][trailing-space-a  ][trailing-space-new-line  ]");

  // Code blocks using 4 spaces (regardless of CodeMirror.tabSize value)
  MT("codeBlocksUsing4Spaces",
     "    [comment nongye]");

  // Code blocks using 4 spaces with internal indentation
  MT("codeBlocksUsing4SpacesIndentation",
     "    [comment bar]",
     "        [comment hello]",
     "            [comment world]",
     "    [comment nongye]",
     "bar");

  // Code blocks using 4 spaces with internal indentation
  MT("codeBlocksUsing4SpacesIndentation",
     " nongye",
     "    [comment bar]",
     "        [comment hello]",
     "    [comment world]");

  // Code blocks should end even after extra indented lines
  MT("codeBlocksWithTrailingIndentedLine",
     "    [comment nongye]",
     "        [comment bar]",
     "    [comment baz]",
     "    ",
     "hello");

  // Code blocks using 1 tab (regardless of CodeMirror.indentWithTabs value)
  MT("codeBlocksUsing1Tab",
     "\t[comment nongye]");

  // Inline code using backticks
  MT("inlineCodeUsingBackticks",
     "nongye [comment `bar`]");

  // Block code using single backtick (shouldn't work)
  MT("blockCodeSingleBacktick",
     "[comment `]",
     "nongye",
     "[comment `]");

  // Unclosed backticks
  // Instead of simply marking as CODE, it would be nice to have an
  // incomplete flag for CODE, that is styled slightly different.
  MT("unclosedBackticks",
     "nongye [comment `bar]");

  // Per documentation: "To include a literal backtick character within a
  // code span, you can use multiple backticks as the opening and closing
  // delimiters"
  MT("doubleBackticks",
     "[comment ``nongye ` bar``]");

  // Tests based on Dingus
  // http://daringfireball.net/projects/markdown/dingus
  //
  // Multiple backticks within an inline code block
  MT("consecutiveBackticks",
     "[comment `nongye```bar`]");

  // Multiple backticks within an inline code block with a second code block
  MT("consecutiveBackticks",
     "[comment `nongye```bar`] hello [comment `world`]");

  // Unclosed with several different groups of backticks
  MT("unclosedBackticks",
     "[comment ``nongye ``` bar` hello]");

  // Closed with several different groups of backticks
  MT("closedBackticks",
     "[comment ``nongye ``` bar` hello``] world");

  // atx headers
  // http://daringfireball.net/projects/markdown/syntax#header

  MT("atxH1",
     "[header&header-1 # nongye]");

  MT("atxH2",
     "[header&header-2 ## nongye]");

  MT("atxH3",
     "[header&header-3 ### nongye]");

  MT("atxH4",
     "[header&header-4 #### nongye]");

  MT("atxH5",
     "[header&header-5 ##### nongye]");

  MT("atxH6",
     "[header&header-6 ###### nongye]");

  // H6 - 7x '#' should still be H6, per Dingus
  // http://daringfireball.net/projects/markdown/dingus
  MT("atxH6NotH7",
     "[header&header-6 ####### nongye]");

  // Inline styles should be parsed inside headers
  MT("atxH1inline",
     "[header&header-1 # nongye ][header&header-1&em *bar*]");

  // Setext headers - H1, H2
  // Per documentation, "Any number of underlining =’s or -’s will work."
  // http://daringfireball.net/projects/markdown/syntax#header
  // Ideally, the text would be marked as `header` as well, but this is
  // not really feasible at the moment. So, instead, we're testing against
  // what works today, to avoid any regressions.
  //
  // Check if single underlining = works
  MT("setextH1",
     "nongye",
     "[header&header-1 =]");

  // Check if 3+ ='s work
  MT("setextH1",
     "nongye",
     "[header&header-1 ===]");

  // Check if single underlining - works
  MT("setextH2",
     "nongye",
     "[header&header-2 -]");

  // Check if 3+ -'s work
  MT("setextH2",
     "nongye",
     "[header&header-2 ---]");

  // Single-line blockquote with trailing space
  MT("blockquoteSpace",
     "[quote&quote-1 > nongye]");

  // Single-line blockquote
  MT("blockquoteNoSpace",
     "[quote&quote-1 >nongye]");

  // No blank line before blockquote
  MT("blockquoteNoBlankLine",
     "nongye",
     "[quote&quote-1 > bar]");

  // Nested blockquote
  MT("blockquoteSpace",
     "[quote&quote-1 > nongye]",
     "[quote&quote-1 >][quote&quote-2 > nongye]",
     "[quote&quote-1 >][quote&quote-2 >][quote&quote-3 > nongye]");

  // Single-line blockquote followed by normal paragraph
  MT("blockquoteThenParagraph",
     "[quote&quote-1 >nongye]",
     "",
     "bar");

  // Multi-line blockquote (lazy mode)
  MT("multiBlockquoteLazy",
     "[quote&quote-1 >nongye]",
     "[quote&quote-1 bar]");

  // Multi-line blockquote followed by normal paragraph (lazy mode)
  MT("multiBlockquoteLazyThenParagraph",
     "[quote&quote-1 >nongye]",
     "[quote&quote-1 bar]",
     "",
     "hello");

  // Multi-line blockquote (non-lazy mode)
  MT("multiBlockquote",
     "[quote&quote-1 >nongye]",
     "[quote&quote-1 >bar]");

  // Multi-line blockquote followed by normal paragraph (non-lazy mode)
  MT("multiBlockquoteThenParagraph",
     "[quote&quote-1 >nongye]",
     "[quote&quote-1 >bar]",
     "",
     "hello");

  // Check list types

  MT("listAsterisk",
     "nongye",
     "bar",
     "",
     "[variable-2 * nongye]",
     "[variable-2 * bar]");

  MT("listPlus",
     "nongye",
     "bar",
     "",
     "[variable-2 + nongye]",
     "[variable-2 + bar]");

  MT("listDash",
     "nongye",
     "bar",
     "",
     "[variable-2 - nongye]",
     "[variable-2 - bar]");

  MT("listNumber",
     "nongye",
     "bar",
     "",
     "[variable-2 1. nongye]",
     "[variable-2 2. bar]");

  // Lists require a preceding blank line (per Dingus)
  MT("listBogus",
     "nongye",
     "1. bar",
     "2. hello");

  // List after header
  MT("listAfterHeader",
     "[header&header-1 # nongye]",
     "[variable-2 - bar]");

  // Formatting in lists (*)
  MT("listAsteriskFormatting",
     "[variable-2 * ][variable-2&em *nongye*][variable-2  bar]",
     "[variable-2 * ][variable-2&strong **nongye**][variable-2  bar]",
     "[variable-2 * ][variable-2&strong **][variable-2&em&strong *nongye**][variable-2&em *][variable-2  bar]",
     "[variable-2 * ][variable-2&comment `nongye`][variable-2  bar]");

  // Formatting in lists (+)
  MT("listPlusFormatting",
     "[variable-2 + ][variable-2&em *nongye*][variable-2  bar]",
     "[variable-2 + ][variable-2&strong **nongye**][variable-2  bar]",
     "[variable-2 + ][variable-2&strong **][variable-2&em&strong *nongye**][variable-2&em *][variable-2  bar]",
     "[variable-2 + ][variable-2&comment `nongye`][variable-2  bar]");

  // Formatting in lists (-)
  MT("listDashFormatting",
     "[variable-2 - ][variable-2&em *nongye*][variable-2  bar]",
     "[variable-2 - ][variable-2&strong **nongye**][variable-2  bar]",
     "[variable-2 - ][variable-2&strong **][variable-2&em&strong *nongye**][variable-2&em *][variable-2  bar]",
     "[variable-2 - ][variable-2&comment `nongye`][variable-2  bar]");

  // Formatting in lists (1.)
  MT("listNumberFormatting",
     "[variable-2 1. ][variable-2&em *nongye*][variable-2  bar]",
     "[variable-2 2. ][variable-2&strong **nongye**][variable-2  bar]",
     "[variable-2 3. ][variable-2&strong **][variable-2&em&strong *nongye**][variable-2&em *][variable-2  bar]",
     "[variable-2 4. ][variable-2&comment `nongye`][variable-2  bar]");

  // Paragraph lists
  MT("listParagraph",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]");

  // Multi-paragraph lists
  //
  // 4 spaces
  MT("listMultiParagraph",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "    [variable-2 hello]");

  // 4 spaces, extra blank lines (should still be list, per Dingus)
  MT("listMultiParagraphExtra",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "",
     "    [variable-2 hello]");

  // 4 spaces, plus 1 space (should still be list, per Dingus)
  MT("listMultiParagraphExtraSpace",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "     [variable-2 hello]",
     "",
     "    [variable-2 world]");

  // 1 tab
  MT("listTab",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "\t[variable-2 hello]");

  // No indent
  MT("listNoIndent",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "hello");

  // Blockquote
  MT("blockquote",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "    [variable-2&quote&quote-1 > hello]");

  // Code block
  MT("blockquoteCode",
     "[variable-2 * nongye]",
     "",
     "[variable-2 * bar]",
     "",
     "        [comment > hello]",
     "",
     "    [variable-2 world]");

  // Code block followed by text
  MT("blockquoteCodeText",
     "[variable-2 * nongye]",
     "",
     "    [variable-2 bar]",
     "",
     "        [comment hello]",
     "",
     "    [variable-2 world]");

  // Nested list

  MT("listAsteriskNested",
     "[variable-2 * nongye]",
     "",
     "    [variable-3 * bar]");

  MT("listPlusNested",
     "[variable-2 + nongye]",
     "",
     "    [variable-3 + bar]");

  MT("listDashNested",
     "[variable-2 - nongye]",
     "",
     "    [variable-3 - bar]");

  MT("listNumberNested",
     "[variable-2 1. nongye]",
     "",
     "    [variable-3 2. bar]");

  MT("listMixed",
     "[variable-2 * nongye]",
     "",
     "    [variable-3 + bar]",
     "",
     "        [keyword - hello]",
     "",
     "            [variable-2 1. world]");

  MT("listBlockquote",
     "[variable-2 * nongye]",
     "",
     "    [variable-3 + bar]",
     "",
     "        [quote&quote-1&variable-3 > hello]");

  MT("listCode",
     "[variable-2 * nongye]",
     "",
     "    [variable-3 + bar]",
     "",
     "            [comment hello]");

  // Code with internal indentation
  MT("listCodeIndentation",
     "[variable-2 * nongye]",
     "",
     "        [comment bar]",
     "            [comment hello]",
     "                [comment world]",
     "        [comment nongye]",
     "    [variable-2 bar]");

  // List nesting edge cases
  MT("listNested",
    "[variable-2 * nongye]",
    "",
    "    [variable-3 * bar]",
    "",
    "       [variable-2 hello]"
  );
  MT("listNested",
    "[variable-2 * nongye]",
    "",
    "    [variable-3 * bar]",
    "",
    "      [variable-3 * nongye]"
  );

  // Code followed by text
  MT("listCodeText",
     "[variable-2 * nongye]",
     "",
     "        [comment bar]",
     "",
     "hello");

  // Following tests directly from official Markdown documentation
  // http://daringfireball.net/projects/markdown/syntax#hr

  MT("hrSpace",
     "[hr * * *]");

  MT("hr",
     "[hr ***]");

  MT("hrLong",
     "[hr *****]");

  MT("hrSpaceDash",
     "[hr - - -]");

  MT("hrDashLong",
     "[hr ---------------------------------------]");

  // Inline link with title
  MT("linkTitle",
     "[link [[nongye]]][string (http://example.com/ \"bar\")] hello");

  // Inline link without title
  MT("linkNoTitle",
     "[link [[nongye]]][string (http://example.com/)] bar");

  // Inline link with image
  MT("linkImage",
     "[link [[][tag ![[nongye]]][string (http://example.com/)][link ]]][string (http://example.com/)] bar");

  // Inline link with Em
  MT("linkEm",
     "[link [[][link&em *nongye*][link ]]][string (http://example.com/)] bar");

  // Inline link with Strong
  MT("linkStrong",
     "[link [[][link&strong **nongye**][link ]]][string (http://example.com/)] bar");

  // Inline link with EmStrong
  MT("linkEmStrong",
     "[link [[][link&strong **][link&em&strong *nongye**][link&em *][link ]]][string (http://example.com/)] bar");

  // Image with title
  MT("imageTitle",
     "[tag ![[nongye]]][string (http://example.com/ \"bar\")] hello");

  // Image without title
  MT("imageNoTitle",
     "[tag ![[nongye]]][string (http://example.com/)] bar");

  // Image with asterisks
  MT("imageAsterisks",
     "[tag ![[*nongye*]]][string (http://example.com/)] bar");

  // Not a link. Should be normal text due to square brackets being used
  // regularly in text, especially in quoted material, and no space is allowed
  // between square brackets and parentheses (per Dingus).
  MT("notALink",
     "[[nongye]] (bar)");

  // Reference-style links
  MT("linkReference",
     "[link [[nongye]]][string [[bar]]] hello");

  // Reference-style links with Em
  MT("linkReferenceEm",
     "[link [[][link&em *nongye*][link ]]][string [[bar]]] hello");

  // Reference-style links with Strong
  MT("linkReferenceStrong",
     "[link [[][link&strong **nongye**][link ]]][string [[bar]]] hello");

  // Reference-style links with EmStrong
  MT("linkReferenceEmStrong",
     "[link [[][link&strong **][link&em&strong *nongye**][link&em *][link ]]][string [[bar]]] hello");

  // Reference-style links with optional space separator (per docuentation)
  // "You can optionally use a space to separate the sets of brackets"
  MT("linkReferenceSpace",
     "[link [[nongye]]] [string [[bar]]] hello");

  // Should only allow a single space ("...use *a* space...")
  MT("linkReferenceDoubleSpace",
     "[[nongye]]  [[bar]] hello");

  // Reference-style links with implicit link name
  MT("linkImplicit",
     "[link [[nongye]]][string [[]]] hello");

  // @todo It would be nice if, at some point, the document was actually
  // checked to see if the referenced link exists

  // Link label, for reference-style links (taken from documentation)

  MT("labelNoTitle",
     "[link [[nongye]]:] [string http://example.com/]");

  MT("labelIndented",
     "   [link [[nongye]]:] [string http://example.com/]");

  MT("labelSpaceTitle",
     "[link [[nongye bar]]:] [string http://example.com/ \"hello\"]");

  MT("labelDoubleTitle",
     "[link [[nongye bar]]:] [string http://example.com/ \"hello\"] \"world\"");

  MT("labelTitleDoubleQuotes",
     "[link [[nongye]]:] [string http://example.com/  \"bar\"]");

  MT("labelTitleSingleQuotes",
     "[link [[nongye]]:] [string http://example.com/  'bar']");

  MT("labelTitleParenthese",
     "[link [[nongye]]:] [string http://example.com/  (bar)]");

  MT("labelTitleInvalid",
     "[link [[nongye]]:] [string http://example.com/] bar");

  MT("labelLinkAngleBrackets",
     "[link [[nongye]]:] [string <http://example.com/>  \"bar\"]");

  MT("labelTitleNextDoubleQuotes",
     "[link [[nongye]]:] [string http://example.com/]",
     "[string \"bar\"] hello");

  MT("labelTitleNextSingleQuotes",
     "[link [[nongye]]:] [string http://example.com/]",
     "[string 'bar'] hello");

  MT("labelTitleNextParenthese",
     "[link [[nongye]]:] [string http://example.com/]",
     "[string (bar)] hello");

  MT("labelTitleNextMixed",
     "[link [[nongye]]:] [string http://example.com/]",
     "(bar\" hello");

  MT("linkWeb",
     "[link <http://example.com/>] nongye");

  MT("linkWebDouble",
     "[link <http://example.com/>] nongye [link <http://example.com/>]");

  MT("linkEmail",
     "[link <user@example.com>] nongye");

  MT("linkEmailDouble",
     "[link <user@example.com>] nongye [link <user@example.com>]");

  MT("emAsterisk",
     "[em *nongye*] bar");

  MT("emUnderscore",
     "[em _foo_] bar");

  MT("emInWordAsterisk",
     "nongye[em *bar*]hello");

  MT("emInWordUnderscore",
     "nongye[em _bar_]hello");

  // Per documentation: "...surround an * or _ with spaces, it’ll be
  // treated as a literal asterisk or underscore."

  MT("emEscapedBySpaceIn",
     "nongye [em _bar _ hello_] world");

  MT("emEscapedBySpaceOut",
     "nongye _ bar[em _hello_]world");

  MT("emEscapedByNewline",
     "nongye",
     "_ bar[em _hello_]world");

  // Unclosed emphasis characters
  // Instead of simply marking as EM / STRONG, it would be nice to have an
  // incomplete flag for EM and STRONG, that is styled slightly different.
  MT("emIncompleteAsterisk",
     "nongye [em *bar]");

  MT("emIncompleteUnderscore",
     "nongye [em _bar]");

  MT("strongAsterisk",
     "[strong **nongye**] bar");

  MT("strongUnderscore",
     "[strong __foo__] bar");

  MT("emStrongAsterisk",
     "[em *nongye][em&strong **bar*][strong hello**] world");

  MT("emStrongUnderscore",
     "[em _foo][em&strong __bar_][strong hello__] world");

  // "...same character must be used to open and close an emphasis span.""
  MT("emStrongMixed",
     "[em _foo][em&strong **bar*hello__ world]");

  MT("emStrongMixed",
     "[em *nongye][em&strong __bar_hello** world]");

  // These characters should be escaped:
  // \   backslash
  // `   backtick
  // *   asterisk
  // _   underscore
  // {}  curly braces
  // []  square brackets
  // ()  parentheses
  // #   hash mark
  // +   plus sign
  // -   minus sign (hyphen)
  // .   dot
  // !   exclamation mark

  MT("escapeBacktick",
     "nongye \\`bar\\`");

  MT("doubleEscapeBacktick",
     "nongye \\\\[comment `bar\\\\`]");

  MT("escapeAsterisk",
     "nongye \\*bar\\*");

  MT("doubleEscapeAsterisk",
     "nongye \\\\[em *bar\\\\*]");

  MT("escapeUnderscore",
     "nongye \\_bar\\_");

  MT("doubleEscapeUnderscore",
     "nongye \\\\[em _bar\\\\_]");

  MT("escapeHash",
     "\\# nongye");

  MT("doubleEscapeHash",
     "\\\\# nongye");

  MT("escapeNewline",
     "\\",
     "[em *nongye*]");


  // Tests to make sure GFM-specific things aren't getting through

  MT("taskList",
     "[variable-2 * [ ]] bar]");

  MT("fencedCodeBlocks",
     "[comment ```]",
     "nongye",
     "[comment ```]");

  // Tests that require XML mode

  MT("xmlMode",
     "[tag&bracket <][tag div][tag&bracket >]",
     "*nongye*",
     "[tag&bracket <][tag http://github.com][tag&bracket />]",
     "[tag&bracket </][tag div][tag&bracket >]",
     "[link <http://github.com/>]");

  MT("xmlModeWithMarkdownInside",
     "[tag&bracket <][tag div] [attribute markdown]=[string 1][tag&bracket >]",
     "[em *nongye*]",
     "[link <http://github.com/>]",
     "[tag </div>]",
     "[link <http://github.com/>]",
     "[tag&bracket <][tag div][tag&bracket >]",
     "[tag&bracket </][tag div][tag&bracket >]");

})();
