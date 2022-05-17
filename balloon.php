button[aria-label][data-balloon-pos] {
  overflow: visible; }

[aria-label][data-balloon-pos] {
  position: relative;
  cursor: pointer; }
  [aria-label][data-balloon-pos]:after {
    opacity: 0;
    pointer-events: none;
    transition: all .18s ease-out .18s;
    text-indent: 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-weight: normal;
    font-style: normal;
    text-shadow: none;
    font-size: 12px;
    background: rgba(16, 16, 16, 0.95);
    border-radius: 2px;
    color: #fff;
    content: attr(aria-label);
    padding: .5em 1em;
    position: absolute;
    white-space: nowrap;
    z-index: 10; }
  [aria-label][data-balloon-pos]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-top-color: rgba(16, 16, 16, 0.95);
    opacity: 0;
    pointer-events: none;
    transition: all .18s ease-out .18s;
    content: "";
    position: absolute;
    z-index: 10; }
  [aria-label][data-balloon-pos]:hover:before, [aria-label][data-balloon-pos]:hover:after, [aria-label][data-balloon-pos][data-balloon-visible]:before, [aria-label][data-balloon-pos][data-balloon-visible]:after, [aria-label][data-balloon-pos]:not([data-balloon-nofocus]):focus:before, [aria-label][data-balloon-pos]:not([data-balloon-nofocus]):focus:after {
    opacity: 1;
    pointer-events: none; }
  [aria-label][data-balloon-pos].font-awesome:after {
    font-family: FontAwesome, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; }
  [aria-label][data-balloon-pos][data-balloon-break]:after {
    white-space: pre; }
  [aria-label][data-balloon-pos][data-balloon-break][data-balloon-length]:after {
    white-space: pre-line;
    word-break: break-word; }
  [aria-label][data-balloon-pos][data-balloon-blunt]:before, [aria-label][data-balloon-pos][data-balloon-blunt]:after {
    transition: none; }
  [aria-label][data-balloon-pos][data-balloon-pos="up"]:after {
    bottom: 100%;
    left: 50%;
    margin-bottom: 10px;
    transform: translate(-50%, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up"]:before {
    bottom: 100%;
    left: 50%;
    transform: translate(-50%, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="up"][data-balloon-visible]:after {
    transform: translate(-50%, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="up"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="up"][data-balloon-visible]:before {
    transform: translate(-50%, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="up-left"]:after {
    bottom: 100%;
    left: 0;
    margin-bottom: 10px;
    transform: translate(0, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up-left"]:before {
    bottom: 100%;
    left: 5px;
    transform: translate(0, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up-left"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="up-left"][data-balloon-visible]:after {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="up-left"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="up-left"][data-balloon-visible]:before {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="up-right"]:after {
    bottom: 100%;
    right: 0;
    margin-bottom: 10px;
    transform: translate(0, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up-right"]:before {
    bottom: 100%;
    right: 5px;
    transform: translate(0, 4px);
    transform-origin: top; }
  [aria-label][data-balloon-pos][data-balloon-pos="up-right"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="up-right"][data-balloon-visible]:after {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="up-right"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="up-right"][data-balloon-visible]:before {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down"]:after {
    left: 50%;
    margin-top: 10px;
    top: 100%;
    transform: translate(-50%, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down"]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-bottom-color: rgba(16, 16, 16, 0.95);
    left: 50%;
    top: 100%;
    transform: translate(-50%, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="down"][data-balloon-visible]:after {
    transform: translate(-50%, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="down"][data-balloon-visible]:before {
    transform: translate(-50%, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-left"]:after {
    left: 0;
    margin-top: 10px;
    top: 100%;
    transform: translate(0, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-left"]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-bottom-color: rgba(16, 16, 16, 0.95);
    left: 5px;
    top: 100%;
    transform: translate(0, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-left"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="down-left"][data-balloon-visible]:after {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-left"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="down-left"][data-balloon-visible]:before {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-right"]:after {
    right: 0;
    margin-top: 10px;
    top: 100%;
    transform: translate(0, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-right"]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-bottom-color: rgba(16, 16, 16, 0.95);
    right: 5px;
    top: 100%;
    transform: translate(0, calc(4px * -1)); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-right"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="down-right"][data-balloon-visible]:after {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="down-right"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="down-right"][data-balloon-visible]:before {
    transform: translate(0, 0); }
  [aria-label][data-balloon-pos][data-balloon-pos="left"]:after {
    margin-right: 10px;
    right: 100%;
    top: 50%;
    transform: translate(4px, -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="left"]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-left-color: rgba(16, 16, 16, 0.95);
    right: 100%;
    top: 50%;
    transform: translate(4px, -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="left"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="left"][data-balloon-visible]:after {
    transform: translate(0, -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="left"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="left"][data-balloon-visible]:before {
    transform: translate(0, -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="right"]:after {
    left: 100%;
    margin-left: 10px;
    top: 50%;
    transform: translate(calc(4px * -1), -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="right"]:before {
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-right-color: rgba(16, 16, 16, 0.95);
    left: 100%;
    top: 50%;
    transform: translate(calc(4px * -1), -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="right"]:hover:after, [aria-label][data-balloon-pos][data-balloon-pos="right"][data-balloon-visible]:after {
    transform: translate(0, -50%); }
  [aria-label][data-balloon-pos][data-balloon-pos="right"]:hover:before, [aria-label][data-balloon-pos][data-balloon-pos="right"][data-balloon-visible]:before {
    transform: translate(0, -50%); }
  [aria-label][data-balloon-pos][data-balloon-length="small"]:after {
    white-space: normal;
    width: 80px; }
  [aria-label][data-balloon-pos][data-balloon-length="medium"]:after {
    white-space: normal;
    width: 150px; }
  [aria-label][data-balloon-pos][data-balloon-length="large"]:after {
    white-space: pre-line;
    width: 260px; }
  [aria-label][data-balloon-pos][data-balloon-length="xlarge"]:after {
    white-space: pre-line;
    width: 380px; }
    @media screen and (max-width: 768px) {
      [aria-label][data-balloon-pos][data-balloon-length="xlarge"]:after {
        white-space: pre-line;
        width: 90vw; } }
  [aria-label][data-balloon-pos][data-balloon-length="xxlarge"]:after {
    white-space: pre-line;
    width: 450px; }
    @media screen and (max-width: 768px) {
      [aria-label][data-balloon-pos][data-balloon-length="xxlarge"]:after {
        white-space: pre-line;
        width: 90vw; } }
  [aria-label][data-balloon-pos][data-balloon-length="fit"]:after {
    white-space: pre-line;
    width: 100%; }
