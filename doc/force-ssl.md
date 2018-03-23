# Force SSL on live and test
The site will automatically ForceSSL if not in Dev mode. This behavior can be overriden by setting the
`WT_DONT_FORCE_SSL` flag to a TRUTY value in your `.env` file.

## Example of how to disable force SSL in live or test
```env
SS_ENVIRONMENT_TYPE=live
WT_DONT_FORCE_SSL=true
```
