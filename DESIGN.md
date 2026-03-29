# EUVerify Design System Reference

**Creative North Star: "The Digital Notary"**
This design system is built to transform complex B2B compliance into an experience of absolute certainty. We prioritize high-end editorial clarity, quiet authority, and architectural depth, using expansive white space and tonal layering instead of traditional borders.

## Colors
- **Color Mode**: Light
- **Primary Color**: `#00183F` (high-contrast text, more expensive feel than black)
- **Primary Container**: `#0F2D5E`
- **Secondary**: `#0052D1`
- **Background (`surface`)**: `#F8F9FF`
- **Section Background (`surface_container_low`)**: `#EFF4FF`
- **Actionable Cards (`surface_container_lowest`)**: `#FFFFFF`
- **Outline Variant (Ghost Borders)**: `#C4C6D0` (used at 15% opacity)
- **Error/Rejected**: `#FFDAD6` (bg) / `#93000A` (text)
- **Compliant Indicator**: `#97F6C0` (bg) / `#002111` (text)
- **Incompliant Indicator**: `#EA580C` (10% opacity bg) / `#EA580C` (text)

## Typography
- **Font**: Inter
- **Display (LG/MD)**: For high-level compliance percentages (monumental feel).
- **Headline (SM/MD)**: Semi-bold (600).
- **Body (MD/LG)**: 14px-16px with a high line-height of 1.6 to ensure dense data is breathable.
- **Labels (SM/MD)**: 12px Uppercase, +0.05em letter spacing.

## Layout & Components

### The "No-Line" Rule
Prohibit 1px solid borders for sectioning. Contrast should be made through background color shifts (`surface_container_low` against `surface`).

### Tonal Layering
Place cards (`surface_container_lowest`) on a section background (`surface_container_low`) to create natural lift.

### Shadow / Glassmorphism
- Modal elements use a layered shadow: `0px 4px 20px rgba(11, 28, 48, 0.04), 0px 10px 40px rgba(11, 28, 48, 0.06)`. Maximize Glassmorphism (`80% opacity, 20px blur`) for popovers on `surface_container_lowest`.

### Buttons
- **Primary**: Gradient-filled (`primary` to `primary_container`), `6px` radius.
- **Secondary**: `surface_container_high` background with `on_surface` text. No border.
- **Tertiary**: Text only, using `secondary` for interaction.

### Forms
- Avoid heavy strokes. Use `surface_container_highest` (`#D3E4FE`) as a background fill. On focus, transition to `surface_container_lowest` (`#FFFFFF`) with a `2px` ghost border of `secondary`.

### Components
- **Status Badges**: Pill-shaped (full roundedness). High-chroma backgrounds with deeply contrasted text.
- **Lists**: No dividers! Use spacing (0.9rem or 1.1rem) to group by proximity.
- **Compliance Timeline**: A vertical `2px` track in `outline_variant` (10% opacity) with `surface_tint` nodes.

## Rules
- Embrace asymmetry (left-align main content, right-align metadata).
- Use generous white space (e.g. 1.75rem) instead of lines.
- No pure black, pure white borders, or crowded sidebars. The 240px sidebar should be a "Quiet Zone".
