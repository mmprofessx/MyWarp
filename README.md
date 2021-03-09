## MyWarp
MyWrap allows you to add wrappers to your posts, these are styled divs that highlight special sections of your posts.

## Syntax
**Basic syntax:**
```html
[wrap][/wrap]
```

**Styled syntax:**
```html
[wrap style="<Styling options>"][/wrap]
```

**Styling options:**
```
// columns
column                        - same as left in LTR languages and same as right in RTL languages
left                          - same as column, will let you float your container on the left
right                         - will let the container float right
center                        - will position the container in the horizontal center of the page
col2..col5                    - will show the text in multiple columns determined by their amount (2, 3, 4 or 5), only works in modern browsers (no IE9 and below)
colsmall, colmedium, collarge - will also show the text in multiple columns but determined by their width (small, medium or large), only works in modern browsers (no IE9 and below) 

/ / widths – might not work as expected, includes mobile support
half      - fits two columns in a row, should be used in pairs
third     - fits three or two columns in a row, should be used in triplets or together with twothirds
twothirds - fits two columns in a row when used together with third, one 1/3 wide and another 2/3 wide
quarter   - fits four columns in a row, should be used in quads

// alignments
leftalign   - aligns text on the left
rightalign  - aligns text on the right
centeralign - centers the text
justify     - justifies the text

// boxes and notes
box       - creates a box around the container
info      - creates a blue box with an info icon
important - creates an orange box with an important icon
alert     - creates a red box with an alert icon
tip       - creates a yellow box with a tip icon
help      - creates a violet box with a help icon
todo      - creates a cyan box with an to-do icon
download  - creates a green box with a download icon
round     - adds rounded corners to any container with a background color or a border (only works in modern browsers, i.e. no IE)
danger    - creates a red danger safety note
warning   - creates an orange warning safety note
caution   - creates a yellow caution safety note
notice    - creates a blue notice safety note
safety    - creates a green safety note

// marks
hi - marks text as highlighted
lo - marks text as less significant
em - marks text as especially emphasized

// misc
clear   - clears floats
hide    - hides the text per CSS (the text will still appear in the source code, in non-modern browsers and is searchable)
button  - when wrapped around a link, styles it like a button
indent  - indents the text, could be used instead of tab
outdent - "outdents" the text
prewrap - wraps text inside pre-formatted code blocks
```

**Widths:**
You can set any valid widths: %, px, em, rem, ex, ch, vw, vh, pt, pc, cm, mm, in.
Just set the width before or after other styles, e.g.
```
[wrap somestyle 60% anotherstyle]...
```

All except percentages will be reduced to have the maximum width available on smaller screens.

## Screenshots
Screenshot 1 
![Screenshot 1](https://community.mybb.com/uploads/mods/previews/preview_123240_1532676541_70950f1f50f8b37de25fd32c50cebed9.png)
Screenshot 2
![Screenshot 2](https://community.mybb.com/uploads/mods/previews/preview_123240_1532676872_508912d395518aaa8fe1dd4a02a3d5af.png)

## License for MyWrap [wrap] - CC0 1.0 Universal
* To the extent possible under law, Thimo (Thibmo) Braker has waived all copyright and related or neighboring rights to MyWrap. 
* This work is published from: Netherlands.
