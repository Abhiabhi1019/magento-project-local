pipeline {
    agent any

    environment {
        DOCKER_BUILDKIT = '1'
        COMPOSE_DOCKER_CLI_BUILD = '1'
    }

    stages {

        stage('Checkout Code') {
            steps {
                git branch: 'main',
                url: 'https://github.com/Abhiabhi1019/magento-project-local.git'
            }
        }

        stage('Verify Workspace') {
            steps {
                sh '''
                echo "Workspace:"
                pwd
                ls -la
                '''
            }
        }

        stage('Check Docker') {
            steps {
                sh '''
                docker --version
                docker compose version || true
                '''
            }
        }

        stage('Stop Old Containers') {
            steps {
                sh '''
                echo "Stopping old containers..."
                docker compose down || true
                '''
            }
        }

        stage('Build Containers') {
            steps {
                sh '''
                echo "Building containers..."
                docker compose build
                '''
            }
        }

        stage('Start Containers') {
            steps {
                sh '''
                echo "Starting containers..."
                docker compose up -d
                '''
            }
        }

        stage('Verify Containers') {
            steps {
                sh '''
                echo "Running containers:"
                docker ps
                '''
            }
        }

    }

    post {
        success {
            echo 'Magento deployment completed successfully'
        }
        failure {
            echo 'Pipeline failed. Check logs above.'
        }
    }
}
