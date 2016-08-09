# 2.0.0

- Major changes to the way hooks are detected.
- Hooks must now implement a static `hookType` method that returns the type of workflow. For example: "post-diff" is a valid hook type.
- Minor: removed arcanist configuration files.

# 1.0.1

- Remove proselint.
- Add note about setting the arcanist_configuration property.

# 1.0.0

- Initial release.
- Supports post-workflow commands.

Only post-diff has been tested.
