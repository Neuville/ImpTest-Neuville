# Usercentrics CMP Browser SDK
With the Usercentrics CMP Browser SDK our aim is to provide a lightweight library which enables you to build your own fully customized Consent Solution while still leveraging the Usercentrics service database and tools.
We also offer collaboration possibilities with Usercentrics Partners who are able to support you in building your own customized solution. Contact our sales team for more information.
## Installing the dependency
```sh
npm install @usercentrics/cmp-browser-sdk --save
```
## Default (non-TCF) initialization
```ts
import Usercentrics, { UI_LAYER, UI_VARIANT } from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID');
UC.init().then((initialUIValues) => {
  // getSettings() returns all Usercentrics settings you need for your custom solution
  const settings = UC.getSettings();
  // getCategories() returns all categories' and data processing services' information
  const categories = UC.getCategories();
  if (initialUIValues.variant === UI_VARIANT.DEFAULT) {
    switch (initialUIValues.initialLayer) {
      case UI_LAYER.FIRST_LAYER:
        // Show first layer (i.e. privacy banner)
        return;
      case UI_LAYER.PRIVACY_BUTTON:
        // Show privacy button
        return;
      case UI_LAYER.NONE:
      default:
        // Show nothing
        return;
    }
  }
});
```
The constructor also supports an optional [Options](https://docs.usercentrics.com/cmp_browser_sdk/2.4.0/interfaces/options.html) parameter.
## Accept / deny / update services in the default (non-TCF) context
```ts
import Usercentrics, { UserDecision } from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID', { createTcfApiStub: true });
UC.init().then((initialUIValues) => {
  const categories = UC.getCategories();
  const settings = UC.getSettings();
  /**
   * ...
   */
  const onAcceptAllHandler = (): void => {
    UC.acceptAllServices().then(() => {
      // Remember to fetch the now updated categories
      const categories = UC.getCategories();
    });
  };
  const onDenyAllHandler = (): void => {
    UC.denyAllServices().then(() => {
      // Remember to fetch the now updated categories
      const categories = UC.getCategories();
    });
  };
  const onSaveHandler = (userDecisions: UserDecision[]): void => {
    // UserDecisions needs to include all the user choices for each service that were made in your UI
    UC.updateServices(userDecisions).then(() => {
      // Remember to fetch the now updated categories
      const categories = UC.getCategories();
    });
  };
});
```
## TCF initialization
First, make sure **TCF is enabled in your settings**.
```ts
import Usercentrics, { UI_LAYER, UI_VARIANT } from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID', { createTcfApiStub: true });
UC.init().then((initialUIValues) => {
  // getSettings() returns all Usercentrics settings you need for your custom solution
  // NOTE: If TCF is enabled, the ui property of the settings object will always be of type TCFUISettings, not DefaultUISettings.
  const settings = UC.getSettings();
  // getTCFData() returns all TCF related data (vendors, purposes, special features etc.)
  const tcfData = UC.getTCFData();
  if (initialUIValues.variant === UI_VARIANT.TCF) {
    switch (initialUIValues.initialLayer) {
      case UI_LAYER.FIRST_LAYER:
        // NOTE: Remember to call setTCFUIAsOpen()!
        UC.setTCFUIAsOpen();
        // Show TCF first layer
        return;
      case UI_LAYER.PRIVACY_BUTTON:
        // Show privacy button
        return;
      case UI_LAYER.NONE:
      default:
        // Show nothing
        return;
    }
  }
});
```
The constructor also supports an optional [Options](https://docs.usercentrics.com/cmp_browser_sdk/2.4.0/interfaces/options.html) parameter.
For TCF, the `createTcfApiStub` option needs to be set to true in order for the \_\_tcfapi queue to initialize right away (we cannot wait for the settings request to finish).
## Accept / deny / update vendors, purposes, special features in the TCF context
Note that both features and special purposes are for disclosing only and do not require any user decision. They cannot be updated.
Note that if TCF is enabled, the default (non-TCF) data is still available (e.g. getCategories()). A hybrid UI can be built if both
sets of methods (TCF and default (non-TCF)) are called.
```ts
import Usercentrics, { TCF_DECISION_UI_LAYER } from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID', { createTcfApiStub: true });
UC.init().then((initialUIValues) => {
  const settings = UC.getSettings();
  const tcfData = UC.getTCFData();
  /**
   * ...
   */
  // The fromLayer parameter needs to identify the layer from which the acceptAll button was triggered.
  const onAcceptAllHandler = (fromLayer: TCF_DECISION_UI_LAYER): void => {
    UC.acceptAllForTCF(fromLayer).then(() => {
      // Remember to fetch the new (updated) tcfData
      const tcfData = UC.getTCFData();
    });
  };
  // The fromLayer parameter needs to identify the layer from which the denyAll button was triggered.
  const onDenyAllHandler = (fromLayer: TCF_DECISION_UI_LAYER): void => {
    UC.denyAllForTCF(fromLayer).then(() => {
      // Remember to fetch the new (updated) tcfData
      const tcfData = UC.getTCFData();
    });
  };
  // The fromLayer parameter needs to identify the layer from which the save button was triggered.
  const onSaveHandler = (tcfUserDecisions: TCFUserDecisions, fromLayer: TCF_DECISION_UI_LAYER): void => {
    // TCFUserDecisions needs to include all the user choices for each vendor, purpose, special feature that were made in your UI
    UC.updateChoicesForTCF(tcfUserDecisions, fromLayer).then(() => {
      // Remember to fetch the new (updated) tcfData
      const tcfData = UC.getTCFData();
    });
  };
  // Special handler for closing the TCF UI without any user changes (e.g. for any close button / click-away handler)
  const onTCFUICloseHandler = (): void => {
    UC.setTCFUIAsClosed();
  };
});
```
## Changing the language
After UC is initialized you can change the language by calling:
```ts
UC.changeLanguage('NEW_LANGUAGE').then(() => {
  // Remember to fetch new (translated) settings
  const settings = UC.getSettings();
  // If you use the default (non-TCF) setup, make sure to fetch new (translated) categories / settings
  const categories = UC.getCategories();
  // If you use the TCF setup, make sure to fetch new (translated) tcfData
  const tcfData = UC.getTCFData();
});
```
## Changing the view
After UC is initialized you have to update the SDK after every view change:
```ts
const enum UI_LAYER {
  FIRST_LAYER,
  NONE,
  PRIVACY_BUTTON,
  SECOND_LAYER,
}
UC.updateLayer(UI_LAYER.FIRST_LAYER).then(() => {
  // Remember to fetch new (translated) settings
  const settings = UC.getSettings();
  // If you use the default (non-TCF) setup, make sure to fetch new (translated) categories / settings
  const categories = UC.getCategories();
  // If you use the TCF setup, make sure to fetch new (translated) tcfData
  const tcfData = UC.getTCFData();
});
```
## Cross-Device Consent Sharing
**NOTE**: If the given `controllerId` returns no history from the Usercentrics backend, that `controllerId` will not be updated for the end user.
### controllerId is known before init
```js
import Usercentrics from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID', { controllerId: 'CONTROLLER_ID_FOR_END_USER' });
UC.init().then((initialView) => {
  /**
   * ...
   */
});
```
### controllerId is known after init
```js
import Usercentrics from '@usercentrics/cmp-browser-sdk';
const UC = new Usercentrics('YOUR_USERCENTRICS_SETTINGS_ID');
UC.init().then((initialView) => {
  /**
   * ...
   */
  UC.restoreUserSession('CONTROLLER_ID_FOR_END_USER').then(() => {
    /**
     * ...
     */
  });
});
```
## IE11 compatibility
If your Consent Solution should work with IE11 (or other legacy browsers), then there's a few extra steps you need to do:
- Include a `CustomEvent` polyfill
  - https://www.npmjs.com/package/custom-event-polyfill
- Include a `fetch` polyfill
  - https://www.npmjs.com/package/whatwg-fetch
Also you'll have to have `Babel (with core-js)` (or similar) in your build setup to make sure, that `Symbol` etc. get polyfilled.
## Script tag support
You can also use the SDK as a `script` tag on your site:
```html
<script src="https://app.usercentrics.eu/browser-sdk/2.4.0/bundle.js"></script>
```
You can now access all methods/constants by using them from within the `UC_SDK` namespace:
```js
const UC = new UC_SDK.default('YOUR_USERCENTRICS_SETTINGS_ID');
UC.init().then((initialUIValues) => {
  // getCategories() returns all categories' and data processing services' information
  const categories = UC.getCategories();
  // getSettings() returns all Usercentrics settings you need for your custom solution
  const settings = UC.getSettings();
  if (initialUIValues.variant === UC_SDK.UI_VARIANT.DEFAULT) {
    switch (initialUIValues.initialLayer) {
      case UC_SDK.UI_LAYER.FIRST_LAYER:
        // Show first layer (i.e. privacy banner)
        return;
      case UC_SDK.UI_LAYER.PRIVACY_BUTTON:
        // Show privacy button
        return;
      case UC_SDK.UI_LAYER.NONE:
      default:
        // Show nothing
        return;
    }
  }
});
```
**NOTE**: If you need Internet Explorer 11 support, you can point the `src` attribute to `https://app.usercentrics.eu/browser-sdk/2.4.0/bundle_legacy.js`.
## Considerations for building your custom TCF v2.0 UI
**Note**: This does NOT apply if you use the unaltered Usercentrics UI together with this SDK
If you plan to build your own custom UI for TCF v2.0, Usercentrics cannot be liable that your custom UI conforms to all the IAB rules and guidelines. In this case, you can still use this SDK, but you need to register your solution at the IAB yourself. You can then enter your cmp-id (provided by the IAB) and cmp-version through the Usercentrics Admin Interface. In the case that you build your own TCF v2.0 UI it is NOT allowed to use the default Usercentrics cmp-id and cmp-version.
Additionally, the IAB will provide you with your own subdomain on the `consensu.org domain`. This subdomain is needed for settings the global-scope `euconsent-v2` cookie. In order for the TCF global-scope to work as intended with this SDK, you need to host a `cookie-handler iframe` on your own `consensu.org subdomain`. You can copy the following iframe `view-source:https://usercentrics.mgr.consensu.org/browser-sdk/2.4.0/cookie-bridge.html` (view page source). Make sure to provide your own `consensu.org subdomain` in the Usercentrics admin settings. Make sure the subdomain starts with `https://`. For your development setup to work correctly we also recommend adding port 443 (https) at the end (e.g. `https://YOUR_COMPANY_NAME.mgr.consensu.org:443`). You also need to provide the relative path to the iframe (including the filename) on that subdomain (e.g. `/YOUR_CURRENT_VERSION/cookie-bridge.html`) .
## Documentation
Documentation can be found on our [documentation website](https://docs.usercentrics.com/cmp_browser_sdk/2.4.0/index.html).