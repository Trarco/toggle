# 📦 Moodle Block: Toggle

**Toggle** is a custom Moodle block that allows teachers to display collapsible sections, each with a title, optional subtitle, and structured list content. It’s perfect for presenting organized, nested information in a clean, user-friendly format.

## ✨ Features

- ✅ Custom block title and description
- ✅ Repeatable **sections** with:
  - Title
  - Optional subtitle
  - Content area supporting nested **ordered lists and sub-items** using simple text syntax
- ✅ Responsive design
- ✅ Multiple block instances per course
- ✅ Only available to users with editing capabilities (e.g. `editingteacher`, `manager`)
- ✅ Uses Moodle’s built-in block configuration interface
- ✅ Clean and customizable HTML output with Mustache templates

## 🧩 Requirements

- Moodle 4.x (tested on 4.3)
- User must have the capability `block/toggle:addinstance`

## 📂 Installation

1. Clone or download this repository into your Moodle `blocks/` directory:
 - cd /path/to/moodle/blocks
 - git clone https://github.com/yourusername/moodle-block_toggle.git toggle
2. Log in to Moodle as an admin
3. Visit the Site Administration area to trigger the plugin installation
4. Follow the on-screen instructions

## 🛡 Capabilities

| Capability                 | Description                   | Allowed roles            |
| -------------------------- | ----------------------------- | ------------------------ |
| `block/toggle:addinstance` | Add the block to course pages | Editing teacher, Manager |

## 📝 Content Syntax Example

In the section content field, you can write plain text like this:

```text
Main point one
- Subpoint A
- Subpoint B
Main point two
- Subpoint C
- Subpoint D
```

Which will render as:

1. Main point one
    a. Subpoint A
    b. Subpoint B
2. Main point two

## 🌍 Localization

All text strings are defined in `lang/en/block_toggle.php`.

## 👨‍💻 Author

Developed by Marco Traina
For support or contributions, open an issue or pull request on GitHub.

## 📄 License

This plugin is licensed under the [GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html).