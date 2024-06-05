import {Link} from "@inertiajs/react";
import {Toaster} from "react-hot-toast";

const MainLayout = ({children}) => {
    return (
        <div>
            <Toaster/>
            <header className="fixed w-full backdrop-blur-md border-b border-zinc-100 px-4 lg:px-6 py-2.5 bg-white/70 z-10">
                <div className="container mx-auto flex justify-between items-center">
                    <Link href="/" className="text-2xl font-bold uppercase">Eventeq</Link>
                </div>
            </header>

            <main className="container mx-auto p-4">
                {children}
            </main>

            <footer className="text-zinc-600 body-font">
                <div className="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
                    <a className="flex title-font font-medium items-center md:justify-start justify-center text-zinc-900">
                        <span className="ml-3 text-xl">Codenteq</span>
                    </a>
                    <p className="text-sm text-zinc-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-zinc-200 sm:py-2 sm:mt-0 mt-4">
                        &#169; 2021-2024 Codenteq.
                    </p>
                    <a href="https://codenteq.com"
                       className="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
                        Codenteq.com
                    </a>
                </div>
            </footer>
        </div>
    );
};

export default MainLayout;
