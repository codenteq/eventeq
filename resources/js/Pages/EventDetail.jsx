import React, {useEffect} from 'react';
import MainLayout from "../Layouts/MainLayout.jsx";
import {Button} from "@codenteq/interfeys";
import {Link, usePage} from "@inertiajs/react";
import toast from "react-hot-toast";

export default function EventDetail({event}) {
    console.log(event);
    return (
        <MainLayout>
            <section className="text-gray-600 body-font relative">
                <div className="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
                    <div className="lg:w-2/3 md:w-1/2 sm:mr-10 p-10 relative">
                        <img className="rounded-t-lg w-full" src={`/storage/${event.img}`} alt={event.name}/>

                        <div className="mt-5">
                            <h3 className="mb-16 text-5xl font-semibold leading-none text-center sm:text-left">
                                {event.name}
                            </h3>

                            <p className="text-xl lg:text-2xl text-zinc-900 dark:text-zinc-100"
                               dangerouslySetInnerHTML={{__html: event.description}}
                            />
                        </div>
                    </div>
                    <div className="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                        <h2 className="text-gray-900 text-lg mb-1 font-medium title-font">Etkinlik tarihi</h2>
                        <p className="leading-relaxed mb-5 text-gray-600">
                        {event.start_date} - {event.end_date}
                        </p>
                        <p className="leading-relaxed text-sm mb-5 text-gray-600">
                            {event.city.name}
                        </p>
                        <Link href={`/applications/${event.id}`} className="mt-3">
                            <Button type="button" label="Başvur" className="w-full"/>
                        </Link>
                    </div>
                </div>
            </section>
        </MainLayout>
    )
}
