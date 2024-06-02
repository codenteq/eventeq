import React, {useState} from 'react';
import Step1 from "./steps/step1.jsx";
import Step2 from "./steps/step2.jsx";
import Step3 from "./steps/step3.jsx";
import Step4 from "./steps/step4.jsx";
import Step5 from "./steps/step5.jsx";
import {IdentificationIcon} from "@heroicons/react/24/outline/index.js";

export default function EventApplicationForm() {
    const [step, setStep] = useState(1);

    const handleNext = () => {
        setStep(step + 1);
    };

    const handlePrev = () => {
        setStep(step - 1);
    };

    const handleFinish = () => {
        console.log('Wizard tamamlandı!');
    };
    return (
        <main className="bg-image-galaxy h-screen w-screen">
            <div className="max-w-6xl mx-auto mb-9 md:mb-16">
                <div className="py-24">
                    <div className="text-center pt-16">
                        <h3 className="text-3xl lg:text-6xl font-bold text-zinc-900 dark:text-zinc-50">
                            Sandras Gökyüzü Gözlem şenliği
                        </h3>
                    </div>
                </div>
            </div>

            <div className="max-w-4xl mx-auto backdrop-blur-md bg-white/35 rounded-lg p-7">
                <ol className="flex items-center w-full mb-24">
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
                    {step === 1 && <Step1 onNext={handleNext}/>}
                    {step === 2 && <Step2 onNext={handleNext} onPrev={handlePrev}/>}
                    {step === 3 && <Step3 onNext={handleNext} onPrev={handlePrev}/>}
                    {step === 4 && <Step4 onNext={handleNext} onPrev={handlePrev}/>}
                    {step === 5 && <Step5 onPrev={handlePrev} onFinish={handleFinish}/>}
                </div>
            </div>
        </main>
    )
}
