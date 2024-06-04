import React, {useEffect, useState} from 'react';
import Step1 from "./steps/step1.jsx";
import Step2 from "./steps/step2.jsx";
import Step3 from "./steps/step3.jsx";
import Step4 from "./steps/step4.jsx";
import Step5 from "./steps/step5.jsx";
import {IdentificationIcon} from "@heroicons/react/24/outline/index.js";
import {Button} from "@codenteq/interfeys";
import {router, useForm, usePage} from "@inertiajs/react";
import MainLayout from "../Layouts/MainLayout.jsx";
import toast from "react-hot-toast";

export default function EventApplicationForm({cities, event}) {
    const [step, setStep] = useState(1);
    const {errors, flash} = usePage().props
    const form = useForm({
        full_name: null,
        email: null,
        phone: null,
        birth_date: null,
        job: null,
        city_id: null,
        participants: [],
        dont_camping_equipment: true,
        tent: null,
        sleeping_bag: null,
        mat: null,
        chair: null,
        telescope: 0,
        telescope_brand: null,
        swaddling: 0,
        swaddling_brand: null,
        binocular: 0,
        camera: 0,
        tripod: 0,
        walkie_talkie: 0,
        computer: 0,
        arrival_date: null,
        departure_date: null,
        event_id: event.id
    })


    const handleNext = () => {
        setStep(step + 1);
    };

    const handlePrev = () => {
        setStep(step - 1);
    };


    function submit(e) {
        e.preventDefault()
        form.post('/applications/' + event.id, {
            data: form.data,
            onSuccess: () => {
                toast.success('Başvurunuz başarıyla alındı.')
                setTimeout(() => {
                    window.location.href = '/events/' + event.id
                }, 2000);
            },
            onError: () => {
                toast.error('Bir hata oluştu. Lütfen tekrar deneyin.')
            }
        })
    }


    return (
        <MainLayout>
            <div className="max-w-6xl mx-auto mb-9 md:mb-16">
                <div className="py-24">
                    <div className="text-center pt-16">
                        <h3 className="text-3xl lg:text-6xl font-bold text-zinc-900 dark:text-zinc-50">
                            {event.name}
                        </h3>
                    </div>
                </div>
            </div>

            <div className="flex flex-col max-w-4xl mx-auto backdrop-blur-md bg-white/35 rounded-lg p-7 gap-y-11 ">
                <ol className="flex items-center w-full">
                    <li className="flex w-full items-center after:w-full dark:after:border-zinc-800 after:h-1 after:border-b after:border-4 after:inline-block">
                        <div
                            className={`flex items-center justify-center ${step === 1 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-100 dark:bg-zinc-700'} rounded-full h-12 w-12 shrink-0`}>
                            <IdentificationIcon className="w-6 h-6 text-brand dark:text-white"/>
                        </div>
                    </li>
                    <li className="flex w-full items-center after:w-full dark:after:border-zinc-800 after:h-1 after:border-b after:border-4 after:inline-block">
                        <div
                            className={`flex items-center justify-center ${step === 2 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-100 dark:bg-zinc-700'} rounded-full h-12 w-12 shrink-0`}>
                            <IdentificationIcon className="w-6 h-6 text-brand dark:text-white"/>
                        </div>
                    </li>
                    <li className="flex w-full items-center after:w-full dark:after:border-zinc-800 after:h-1 after:border-b after:border-4 after:inline-block">
                        <div
                            className={`flex items-center justify-center ${step === 3 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-100 dark:bg-zinc-700'} rounded-full h-12 w-12 shrink-0`}>
                            <IdentificationIcon className="w-6 h-6 text-brand dark:text-white"/>
                        </div>
                    </li>
                    <li className="flex w-full items-center after:w-full dark:after:border-zinc-800 after:h-1 after:border-b after:border-4 after:inline-block">
                        <div
                            className={`flex items-center justify-center ${step === 4 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-100 dark:bg-zinc-700'} rounded-full h-12 w-12 shrink-0`}>
                            <IdentificationIcon className="w-6 h-6 text-brand dark:text-white"/>
                        </div>
                    </li>
                    <li className="flex items-center">
                        <div
                            className={`flex items-center justify-center ${step === 5 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-100 dark:bg-zinc-700'} rounded-full h-12 w-12 shrink-0`}>
                            <IdentificationIcon className="w-6 h-6 text-brand dark:text-white"/>
                        </div>
                    </li>
                </ol>

                <div>
                    <ol className="text-red-600">
                        {Object.entries(errors).map(([key, value], index) => (
                            <li key={index}>{value}</li>
                        ))}
                    </ol>
                </div>

                <form onSubmit={submit} className="flex flex-col gap-y-11">
                    <div>
                        {step === 1 && <Step1 data={form.data} setData={form.setData} cities={cities}/>}
                        {step === 2 && <Step2 data={form.data} setData={form.setData}/>}
                        {step === 3 && <Step3 data={form.data} setData={form.setData}/>}
                        {step === 4 && <Step4 data={form.data} setData={form.setData}/>}
                        {step === 5 && <Step5 data={form.data} setData={form.setData} event={event}/>}
                    </div>

                    <div className={`flex items-center ${step !== 1 ? 'justify-between' : 'justify-end'}`}>
                        {step !== 1 && <Button type="button" label="Geri" onClick={handlePrev}/>}
                        {step !== 5 ?
                            <Button type="button" label="Sonraki" onClick={handleNext}/> : (
                                <Button type="submit" label="Tamamla" disabled={form.processing}/>

                            )}
                    </div>
                </form>

            </div>
        </MainLayout>
    )
}
