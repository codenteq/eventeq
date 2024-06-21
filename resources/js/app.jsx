import {createInertiaApp} from '@inertiajs/react'
import {createRoot} from 'react-dom/client'

import {PostHogProvider} from "posthog-js/react";


const options = {
    api_host: 'https://us.i.posthog.com'
}

createInertiaApp({
    title: title => 'Eventeq',
    resolve: name => {
        const pages = import.meta.glob("./Pages/**/*.jsx", {eager: true});
        return pages[`./Pages/${name}.jsx`]
    },
    setup({el, App, props}) {
        createRoot(el).render(
            <PostHogProvider
                apiKey="phc_z4pthNYl2vICRVSlgdOKUfmCHCebsGI2bJDMFsnKvXc"
                options={options}
                >
                <App {...props} />
            </PostHogProvider>
        )
    },
})
