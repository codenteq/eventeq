import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import {PostHogProvider} from "posthog-js/react";
import posthog from 'posthog-js'

posthog.init('phc_z4pthNYl2vICRVSlgdOKUfmCHCebsGI2bJDMFsnKvXc',
    {
        api_host: 'https://us.i.posthog.com',
        person_profiles: 'identified_only' // or 'always' to create profiles for anonymous users as well
    }
)

createInertiaApp({
    title: title => 'Eventeq',
    resolve: name => {
        const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
        return pages[`./Pages/${name}.jsx`]
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <PostHogProvider
               client={posthog}
            >
                <App {...props} />
            </PostHogProvider>
        )
    },
})
